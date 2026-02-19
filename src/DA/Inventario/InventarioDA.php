<?php

namespace DA\Inventario;

use DateTimeZone;
use DateTime;

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/DA/IInventarioDA.php";

use ABS\Interfaces\DA\IInventarioDA;

class InventarioDA implements IInventarioDA
{
    private $conexion;

    public function __construct($conn)
    {
        $this->conexion = $conn;
    }

    public function obtenerArticulosPorCategoria($categoria)
    {
        $params = array($categoria);
        $query = "SELECT DISTINCT  i.ID_Inventario,a.ID_Articulo,a.num_articulo,a.modelo,a.cantidad,a.direccion,a.marca,a.serial,a.nombre,a.disponibilidad,a.activo,atributos_especificos as atributos
                 FROM dbo.INMASY_Articulos a
                 JOIN dbo.INMASY_Inventario i ON i.id_articulo = a.ID_Articulo
                 WHERE a.id_categoria = ? and a.estado != 'DESECHO' 
                 ORDER BY a.ID_Articulo DESC";
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $reles = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($row['atributos'] != null) {
                $atributos = json_decode($row['atributos'], true);
                $keys = array_keys($atributos);
                foreach ($keys as $key) {
                    $row[$key] = $atributos[$key];
                }
            }
            $reles[] = $row;
        }



        return $reles;
    }
    public function obtenerArticuloPorId($categoria, $id)
    {


        $query = "SELECT a.num_articulo  ,a.nombre as Nombre,a.uso_equipo as Tecnico,a.modelo as Modelo,a.fecha_fabricacion as 'Fabricación',a.serial as Serial,a.estado as Estado,a.marca as  Marca,a.disponibilidad as Disponibilidad,a.direccion as Direccion,a.costo_unitario as Costo,a.cantidad as Cantidad,atributos_especificos as atributos,a.ID_Articulo as ID,a.activo as Activo FROM dbo.INMASY_Articulos a    
                 WHERE a.ID_Articulo = ?";
        $params = array($id);
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $articulo = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        return $articulo;
    }
    public function editarArticulo($articulo)
    {
        sqlsrv_begin_transaction($this->conexion);
        $queryArticulo = "UPDATE dbo.INMASY_Articulos SET nombre = ?, marca = ?, modelo = ?, serial = ?,estado = ?, costo_unitario = ?, cantidad = ?, direccion = ?, activo = ? ,num_articulo = ? WHERE ID_Articulo = ?;
        SELECT id_categoria FROM dbo.INMASY_Articulos WHERE ID_Articulo = ?;";
        $params = [
            $articulo['nombre'] ?: null,
            $articulo['marca'] ?: null,
            $articulo['modelo'] ?: null,
            $articulo['serial'] ?: null,
            $articulo['estado'] ?: null,
            $articulo['costo_unitario'] ?: null,
            $articulo['cantidad'] ?: null,
            $articulo['direccion'] ?: null,
            $articulo['activo'],
            $articulo['num_articulo'] ?: null,
            $articulo['ID_Articulo'] ?: null,
            $articulo['ID_Articulo'] ?: null,
        ];
        $stmt = sqlsrv_prepare($this->conexion, $queryArticulo, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);
            return ['error' => $errors[0]['message']];
        }
        sqlsrv_next_result($stmt);
        $id = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)['id_categoria'];
        sqlsrv_free_stmt($stmt);

        if (isset($articulo['atributos'])) {
            $queryCategoria = "UPDATE dbo.INMASY_Articulos SET atributos_especificos = ? WHERE ID_Articulo = ?";
            $atributos = $articulo['atributos'];
            $paramsCategoria = [
                $atributos,
                $articulo['ID_Articulo']
            ];


            $stmtCategoria = sqlsrv_prepare($this->conexion, $queryCategoria, $paramsCategoria);
            if (!sqlsrv_execute($stmtCategoria)) {
                $errors = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);
                return ['error' => $errors[0]['message']];
            }

            sqlsrv_free_stmt($stmtCategoria);
        }

        sqlsrv_commit($this->conexion);
        return ['success' => true, 'categoria' => $id, 'id' => $articulo['ID_Articulo']];
    }
    public function sacarArticulo($id, $motivo)
    {
        sqlsrv_begin_transaction($this->conexion);
        try {

            $query = "UPDATE  a
                  SET a.estado = 'DESECHO'
                  FROM dbo.INMASY_Inventario i
                  INNER JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = i.id_articulo
                  WHERE i.ID_Inventario= ?
                  ";

            $params = [
                $id
            ];

            $stmt = sqlsrv_query($this->conexion, $query, $params);


            if ($stmt == false) {
                $e = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);

                return ['error' => $e[0]['message'] . "linea 138"];
            }

            sqlsrv_free_stmt($stmt);

            $query = "INSERT INTO dbo.INMASY_SalidasCTM (id_inventario,motivo,fecha_salida) VALUES
            (?,?,?)
                  ";

            $zona = new DateTimeZone('America/Costa_Rica');
            $fechaConZona = new DateTime('now', $zona);
            $params = [
                $id,
                $motivo,
                $fechaConZona->format('Y-m-d H:i:s')
            ];

            $stmt = sqlsrv_query($this->conexion, $query, $params);


            if ($stmt == false) {
                $e = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);

                return ['error' => $e[0]['message'] . "linea 138"];
            }

            sqlsrv_free_stmt($stmt);

            sqlsrv_commit($this->conexion);

            return ['success' => true, 'id' => $id];
        } catch (\Exception $e) {
            return ['error' => $e[0]['message']];
        }
    }
    public function pedirArticulo($pedido)
    {

        sqlsrv_begin_transaction($this->conexion);
        try {
            $queryFormula = "INSERT INTO dbo.INMASY_FormulaRetiro(fecha,direccion,cantidad,num_orden) 
                  VALUES (?,?,?,?);
                  SELECT SCOPE_IDENTITY() AS id;
                  ";

            $params = [
                $pedido['fecha'],
                !empty($pedido['direccion']) ? $pedido['direccion'] : null,
                !empty($pedido['cantidad']) ? $pedido['cantidad'] : null,
                $pedido['num_orden'],
            ];

            $stmt = sqlsrv_query($this->conexion, $queryFormula, $params);


            if ($stmt == false) {
                $e = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);

                return ['error' => $e[0]['message'] . "linea 138"];
            }


            $idFormula = $this->obtenerSiguienteId($stmt);

            $query = "SELECT ID_Inventario as id
                  FROM dbo.INMASY_Inventario
                  WHERE id_articulo = ?";

            $params = array($pedido['id_articulo']);

            $stmt = sqlsrv_query($this->conexion, $query, $params);


            if ($stmt == false) {
                $e = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);

                return ['error' => $e[0]['message'] . "linea 157"];
            }

            $idInventario = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)['id'];

            sqlsrv_free_stmt($stmt);

            $queryPedido = "INSERT INTO dbo.INMASY_PedidosRetiro(id_inventario,id_formula,id_cliente,estado)
                        VALUES (?,?,?,?);
                         SELECT SCOPE_IDENTITY() AS id";
            $params = [
                $idInventario,
                $idFormula,
                $pedido['id_cliente'],
                $pedido['estado']

            ];

            $stmt = sqlsrv_query($this->conexion, $queryPedido, $params);

            if ($stmt == false) {
                $e = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);

                return ['error' => $e[0]['message'] . "linea 180"];
            }

            $idPedido = $this->obtenerSiguienteId($stmt);

            if (empty($pedido['cantidad'])) {
                $query = "UPDATE  a
                  SET a.disponibilidad = 1, uso_equipo = 'EN REVISIÓN'
                  FROM dbo.INMASY_Articulos a
                  INNER JOIN dbo.INMASY_Inventario i ON i.ID_Inventario = ?
                  WHERE a.ID_Articulo = i.id_articulo";

                $params = array($idInventario);

                $stmt = sqlsrv_query($this->conexion, $query, $params);

                if ($stmt == false) {
                    $e = sqlsrv_errors();
                    sqlsrv_rollback($this->conexion);

                    return ['error' => $e[0]['message'] . "linea 199"];
                }
            }

            sqlsrv_commit($this->conexion);

            return ['success' => true, 'id' => $idPedido];
        } catch (\Exception $e) {
            return ['error' => $e[0]['message']];
        }
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
