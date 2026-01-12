<?php

namespace DA\Entradas;

require_once __DIR__ . '/../../ABS/Interfaces/DA/IEntradaDA.php';

use ABS\Interfaces\DA\IEntradaDA;

class EntradaDA implements IEntradaDA
{
    private $conexion;

    public function __construct($conn)
    {
        $this->conexion = $conn;
    }

    public function agregarArticulo($articulo, $adquisicion, $categoria, $almacenamiento)
    {
        sqlsrv_begin_transaction($this->conexion);
        try {

                $queryAdquisicion = "INSERT INTO dbo.INMASY_Adquisicion (fecha_entrega, persona_compra, id_proveedor, numero_factura, numero_fondo, tipo_pago, garantia) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?);
                                 SELECT SCOPE_IDENTITY() AS id;";
                $paramsAdquisicion = [
                    $adquisicion['fecha_adquisicion'] ?? null,
                    $adquisicion['persona_compra'],
                    $adquisicion['proveedor'] ?? null,
                    $adquisicion['numero_factura'] ?? null,
                    $adquisicion['numero_fondo'] ?? null,
                    $adquisicion['tipo_pago'] ?? null,
                    $adquisicion['garantia'] ?? null
                ];
                $stmtAdquisicion = sqlsrv_query($this->conexion, $queryAdquisicion, $paramsAdquisicion);
                if ($stmtAdquisicion === false) {
                    throw new \Exception("Error al insertar la adquisición: " . sqlsrv_errors()[0]['message']);
                }

                
            $idAdquisicion = $this->obtenerSiguienteId($stmtAdquisicion);
            
            $queryArticulo = "INSERT INTO dbo.INMASY_Articulos (nombre, marca, modelo, serial, costo_unitario, estado, direccion, cantidad, activo, disponibilidad, id_caja, atributos_especificos, id_categoria) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
                              SELECT SCOPE_IDENTITY() AS id;";
            $paramsArticulo = [
                $articulo['nombre'],
                $articulo['marca'],
                $articulo['modelo'],
                $articulo['serial'],
                $articulo['costo_unitario'],
                $articulo['estado'],
                $articulo['direccion'],
                $articulo['cantidad'],
                $articulo['activo'],
                $articulo['disponibilidad'],
                $articulo['id_caja'],
                isset($articulo['atributos']) ? $articulo['atributos'] : null,
                $categoria
            ];
            $stmtArticulo = sqlsrv_query($this->conexion, $queryArticulo, $paramsArticulo);
            if ($stmtArticulo === false) {
                throw new \Exception("Error al insertar el artículo: " . sqlsrv_errors()[0]['message']);
            }
            $idArticulo = $this->obtenerSiguienteId($stmtArticulo);

            if ($almacenamiento['tipo'] === 'bodega') {
                $queryBodega = "INSERT INTO dbo.INMASY_BodegaID (id_articulo, numero_cat) VALUES ( ?, ?);
                SELECT SCOPE_IDENTITY() AS id;";
                $paramsBodega = [
                    $idArticulo,
                    $almacenamiento['num_catalogo']
                ];
                $stmtBodega = sqlsrv_query($this->conexion, $queryBodega, $paramsBodega);
                if ($stmtBodega === false) {
                    throw new \Exception("Error al insertar el artículo en bodega: " . sqlsrv_errors()[0]['message']);
                }

                $idBodega = $this->obtenerSiguienteId($stmtBodega);

                $queryEntrante = "INSERT INTO dbo.INMASY_EntranteArticulo (id_bodega, id_adquisicion,fecha_entrada) VALUES (?, ?, ?)
                ";

                $paramsEntrante = [

                    $idBodega,
                    $idAdquisicion,
                    $adquisicion['fecha_adquisicion'] ?? date('Y-m-d H:i:s')
                ];
                $stmtEntrante = sqlsrv_query($this->conexion, $queryEntrante, $paramsEntrante);
                if ($stmtEntrante === false) {
                    throw new \Exception("Error al insertar el artículo entrante: " . sqlsrv_errors()[0]['message']);
                }
                sqlsrv_commit($this->conexion);
                return ['success' => true];
            } else {
                $queryInventario = "INSERT INTO dbo.INMASY_Inventario (id_articulo) VALUES ( ?);
                SELECT SCOPE_IDENTITY() AS id;";
                $paramsInventario = [
                    $idArticulo
                ];
                $stmtInventario = sqlsrv_query($this->conexion, $queryInventario, $paramsInventario);
                if ($stmtInventario === false) {
                    throw new \Exception("Error al insertar el artículo en inventario.");
                }
                $idInventario = $this->obtenerSiguienteId($stmtInventario);
                $queryEntrante = "INSERT INTO dbo.INMASY_EntranteArticulo (id_inventario, id_adquisicion,fecha_entrada) VALUES (?, ?, ?)";
                $paramsEntrante = [

                    $idInventario,
                    $idAdquisicion,
                    $adquisicion['fecha_adquisicion'] ?? date('Y-m-d H:i:s')
                ];
                $stmtEntrante = sqlsrv_query($this->conexion, $queryEntrante, $paramsEntrante);
                if ($stmtEntrante === false) {
                    throw new \Exception("Error al insertar el artículo entrante.");
                }
                sqlsrv_commit($this->conexion);
                return ['success' => true];
            }
        } catch (\Exception $e) {
            sqlsrv_rollback($this->conexion);
            return ['error' => $e->getMessage()];
        }
    }

    public function editarEntrada($entrada)
    {
        // Implementación para editar una entrada
    }

    public function obtenerEntradas()
    {
        $query = "SELECT 
                        e.ID_Entrante as id,
                        p.ID_Proveedor as id_proveedor,
                        ar.ID_Articulo AS id_articulo,
                        a.ID_Adquisicion as id_adquisicion,
                        a.numero_factura AS factura,
                        a.persona_compra AS encargado,
                        p.nombre AS proveedor,
                        e.fecha_entrada AS fecha,
                        IIF(e.id_inventario IS NULL,'Bodega','Inventario') as almacenamiento,
                        ar.nombre as nombre_articulo
                    FROM dbo.INMASY_EntranteArticulo e
                    LEFT JOIN dbo.INMASY_Adquisicion a ON e.id_adquisicion = a.ID_Adquisicion
                    LEFT JOIN dbo.INMASY_Proveedores p ON a.id_proveedor = p.ID_Proveedor
                    LEFT JOIN dbo.INMASY_Articulos ar ON ar.ID_Articulo = (
                        CASE 
                            WHEN e.id_inventario IS NULL THEN (
                                SELECT id_articulo 
                                FROM dbo.INMASY_BodegaID 
                                WHERE ID_Bodega = e.id_bodega
                            )
                            ELSE (
                                SELECT id_articulo
                                FROM dbo.INMASY_Inventario
                                WHERE ID_Inventario = e.id_inventario
                            )
                        END
                    )
                    ORDER BY fecha DESC";
        $stmt = sqlsrv_prepare($this->conexion, $query);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $entradas = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $entradas[] = $row;
        }

        return $entradas;
    }
    public function obtenerCategorias()
    {
        $query = "SELECT ID_Categoria as id, nombre_categoria as nombre FROM dbo.INMASY_Categorias";
        $stmt = sqlsrv_prepare($this->conexion, $query);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $categorias = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $categorias[] = $row;
        }

        return $categorias;
    }
    public function obtenerProveedores()
    {
        $query = "SELECT ID_Proveedor as id ,nombre , telefono , correo, direccion FROM dbo.INMASY_Proveedores";
        $stmt = sqlsrv_prepare($this->conexion, $query);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $proveedores = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $proveedores[] = $row;
        }

        return $proveedores;
    }

    public function obtenerEntradaPorID()
    {
        throw new \Exception('Not implemented');
    }

    private function obtenerSiguienteId($stmt)
    {
        sqlsrv_next_result($stmt);
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($stmt);

        if (!isset($row['id']) || $row['id'] === null) {
            throw new \Exception("SCOPE_IDENTITY retornó NULL");
        }

        return (int)$row['id'];
    }
}
