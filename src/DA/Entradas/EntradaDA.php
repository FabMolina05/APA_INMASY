<?php

namespace DA\Entradas;

require_once __DIR__ . '/../../ABS/Interfaces/DA/IEntradaDA.php';

use ABS\Interfaces\DA\IEntradaDA;
use DateTimeZone;
use DateTime;
use Exception;

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

            $queryAdquisicion = "INSERT INTO dbo.INMASY_Adquisicion (fecha_entrega, persona_compra, id_proveedor, numero_factura, numero_fondo, tipo_pago, garantia,cantidad) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?,?);
                                 SELECT SCOPE_IDENTITY() AS id;";
            $paramsAdquisicion = [
                $adquisicion['fecha_adquisicion'] ?? null,
                $adquisicion['persona_compra'],
                $adquisicion['proveedor'] ?? null,
                $adquisicion['numero_factura'] ?? null,
                $adquisicion['numero_fondo'] ?? null,
                $adquisicion['tipo_pago'] ?? null,
                $adquisicion['garantia'] ?? null,
                $adquisicion['cantidad'] ?? null


            ];
            $stmtAdquisicion = sqlsrv_query($this->conexion, $queryAdquisicion, $paramsAdquisicion);
            if ($stmtAdquisicion === false) {
                throw new \Exception("Error al insertar la adquisición: " . sqlsrv_errors()[0]['message']);
            }


            $idAdquisicion = $this->obtenerSiguienteId($stmtAdquisicion);

            if (!empty($articulo['id_articulo'])) {
                $query = "UPDATE  dbo.INMASY_Articulos
                  SET cantidad = cantidad + ?
                  WHERE ID_Articulo = ?;
                  SELECT ID_Inventario as id FROM dbo.INMASY_Inventario WHERE id_articulo = ?;";

                $params = array($articulo['cantidad'], $articulo['id_articulo'], $articulo['id_articulo']);

                $stmt = sqlsrv_query($this->conexion, $query, $params);

                if ($stmt == false) {
                    $e = sqlsrv_errors();
                    sqlsrv_rollback($this->conexion);

                    return ['error' => $e[0]['message']];
                }

                sqlsrv_next_result($stmt);
                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                $idInventario = $row['id'] ?? null;
                sqlsrv_free_stmt($stmt);

                $queryEntrante = "INSERT INTO dbo.INMASY_EntranteArticulo (id_inventario, id_adquisicion,fecha_entrada) VALUES (?, ?, ?);
                SELECT SCOPE_IDENTITY() AS id;";
                if (!isset($adquisicion['fecha_adquisicion'])) {
                    $zona = new DateTimeZone('America/Costa_Rica');
                    $fechaConZona = new DateTime('now', $zona);
                    $fecha_entrega = $fechaConZona->format('Y-m-d H:i:s');
                } else if (isset($adquisicion['fecha_adquisicion']) && isset($adquisicion['fecha_entrada'])) {
                    $fecha_entrega = $adquisicion['fecha_adquisicion'];
                } else {
                    $fecha_entrega = null;
                }
                $paramsEntrante = [

                    $idInventario,
                    $idAdquisicion,
                    $fecha_entrega
                ];
                $stmtEntrante = sqlsrv_query($this->conexion, $queryEntrante, $paramsEntrante);
                if ($stmtEntrante === false) {
                    throw new \Exception("Error al insertar el artículo entrante.");
                }

                $idEntrante = $this->obtenerSiguienteId($stmtEntrante);
                sqlsrv_commit($this->conexion);
                return ['success' => true, 'id' => $idEntrante];
            }

            $queryArticulo = "INSERT INTO dbo.INMASY_Articulos (nombre, marca, modelo, serial, costo_unitario, estado, direccion, cantidad, activo, disponibilidad, num_articulo,fecha_fabricacion, atributos_especificos, id_categoria) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?);
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
                $articulo['num_articulo'],
                $articulo['fecha_fabricacion'],
                isset($articulo['atributos']) ? $articulo['atributos'] : null,
                $categoria
            ];
            $stmtArticulo = sqlsrv_query($this->conexion, $queryArticulo, $paramsArticulo);
            if ($stmtArticulo === false) {
                throw new \Exception("Error al insertar el artículo: " . sqlsrv_errors()[0]['message']);
            }
            $idArticulo = $this->obtenerSiguienteId($stmtArticulo);

            if ($almacenamiento['tipo'] === 'bodega') {
                $queryBodega = "INSERT INTO dbo.INMASY_Bodega (id_articulo, numero_cat) VALUES ( ?, ?);
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
                if (!isset($adquisicion['fecha_adquisicion'])) {
                    $zona = new DateTimeZone('America/Costa_Rica');
                    $fechaConZona = new DateTime('now', $zona);
                    $fecha_entrega = $fechaConZona->format('Y-m-d H:i:s');
                } else if (isset($adquisicion['fecha_adquisicion']) && isset($adquisicion['fecha_entrada'])) {
                    $fecha_entrega = $adquisicion['fecha_adquisicion'];
                } else {
                    $fecha_entrega = null;
                }
                $paramsEntrante = [

                    $idBodega,
                    $idAdquisicion,
                    $fecha_entrega
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
                $queryEntrante = "INSERT INTO dbo.INMASY_EntranteArticulo (id_inventario, id_adquisicion,fecha_entrada) VALUES (?, ?, ?);
                SELECT SCOPE_IDENTITY() AS id;";
                if (!isset($adquisicion['fecha_adquisicion'])) {
                    $zona = new DateTimeZone('America/Costa_Rica');
                    $fechaConZona = new DateTime('now', $zona);
                    $fecha_entrega = $fechaConZona->format('Y-m-d H:i:s');
                } else if (isset($adquisicion['fecha_adquisicion']) && isset($adquisicion['fecha_entrada'])) {
                    $fecha_entrega = $adquisicion['fecha_adquisicion'];
                } else {
                    $fecha_entrega = null;
                }
                $paramsEntrante = [

                    $idInventario,
                    $idAdquisicion,
                    $fecha_entrega
                ];
                $stmtEntrante = sqlsrv_query($this->conexion, $queryEntrante, $paramsEntrante);
                if ($stmtEntrante === false) {
                    throw new \Exception("Error al insertar el artículo entrante.");
                }

                $idEntrante = $this->obtenerSiguienteId($stmtEntrante);
                sqlsrv_commit($this->conexion);
                return ['success' => true, 'id' => $idEntrante];
            }
        } catch (\Exception $e) {
            sqlsrv_rollback($this->conexion);
            return ['error' => $e->getMessage()];
        }
    }

    public function editarEntrada($entrada)
    {
        try {
            sqlsrv_begin_transaction($this->conexion);

            $query = "UPDATE a 
                  SET a.tipo_pago = ?,
                  a.numero_fondo = ?,
                  a.numero_factura = ?,
                  a.fecha_entrega = ?,
                  a.persona_compra = ?,
                  a.garantia = ?,
                  a.id_proveedor = ?
                  FROM dbo.INMASY_Adquisicion a  
                  INNER JOIN dbo.INMASY_EntranteArticulo e ON e.id_adquisicion = a.ID_Adquisicion
                  WHERE e.ID_Entrante = ?";
            $params = [
                $entrada['tipo_pago'],
                $entrada['numero_fondo'],
                $entrada['numero_factura'],
                $entrada['fecha_adquisicion'],
                $entrada['persona_compra'],
                $entrada['garantia'],
                $entrada['proveedor'],
                $entrada['id_entrada']

            ];

            $stmt = sqlsrv_query($this->conexion, $query, $params);

            if ($stmt === false) {
                sqlsrv_rollback($this->conexion);
                $errors = sqlsrv_errors();
                return ['error' => $errors[0]['message']];
            }

            sqlsrv_commit($this->conexion);

            return ["success" => true, 'id' => $entrada['id_entrada']];
        } catch (\Exception $e) {
            sqlsrv_rollback($this->conexion);
            return ['error' => $e->getMessage()];
        }
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
                        e.fecha_entrada AS 'fecha_entrada',
                        a.fecha_entrega AS 'fecha_entrega',
                        IIF(e.id_inventario IS NULL,'Bodega','Inventario') as almacenamiento,
                        ar.nombre as nombre_articulo,
                        ar.estado
                    FROM dbo.INMASY_EntranteArticulo e
                    LEFT JOIN dbo.INMASY_Adquisicion a ON e.id_adquisicion = a.ID_Adquisicion
                    LEFT JOIN dbo.INMASY_Proveedores p ON a.id_proveedor = p.ID_Proveedor
                    LEFT JOIN dbo.INMASY_Articulos ar ON ar.ID_Articulo = (
                        CASE 
                            WHEN e.id_inventario IS NULL THEN (
                                SELECT id_articulo 
                                FROM dbo.INMASY_Bodega 
                                WHERE ID_Bodega = e.id_bodega
                            )
                            ELSE (
                                SELECT id_articulo
                                FROM dbo.INMASY_Inventario
                                WHERE ID_Inventario = e.id_inventario
                            )
                        END
                    )
                    ORDER BY e.ID_Entrante DESC
                    ";
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
        $query = "SELECT ID_Proveedor as id ,nombre , telefono , direccion FROM dbo.INMASY_Proveedores WHERE activo != 0";
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

    public function obtenerEntradaPorID($id)
    {
        $query = "{CALL dbo.INMASY_obtenerEntrantePorId(?)}";
        $param = array($id);
        $stmt = sqlsrv_prepare($this->conexion, $query, $param);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }

        $entrante = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $entrante;
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

    public function establecerFecha($id)
    {
        $query = 'UPDATE dbo.INMASY_EntranteArticulo SET fecha_entrada = ? WHERE ID_Entrante = ?';
        $zona = new DateTimeZone('America/Costa_Rica');
        $fechaConZona = new DateTime('now', $zona);
        $param = array($fechaConZona->format('Y-m-d H:i:s'), $id);

        sqlsrv_begin_transaction($this->conexion);

        $stmt = sqlsrv_prepare($this->conexion, $query, $param);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);
            return ['error' => $errors[0]['message']];
        }
        sqlsrv_commit($this->conexion);

        return ['success' => true];
    }
}
