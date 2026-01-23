<?php

namespace DA\Inventario;

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
        $query = "SELECT a.ID_Articulo,a.id_caja,a.modelo,a.marca,a.nombre,a.disponibilidad,a.activo,atributos_especificos as atributos
                 FROM dbo.INMASY_Articulos a
                 WHERE a.id_categoria = ?";
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


        $query = "SELECT a.id_caja as CAJA,a.nombre as Nombre,u.nombre_completo as Tecnico,a.modelo as Modelo,a.serial as Serial,a.estado as Estado,a.marca as  Marca,a.disponibilidad as Disponibilidad,a.direccion as Direccion,a.costo_unitario as Costo,a.cantidad as Cantidad,atributos_especificos as atributos,a.ID_Articulo as ID,a.activo as Activo FROM dbo.INMASY_Articulos a
                 LEFT JOIN dbo.INMASY_Usuarios u on a.uso_equipo = u.ID_Usuario
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
        $queryArticulo = "UPDATE dbo.INMASY_Articulos SET nombre = ?, marca = ?, modelo = ?, serial = ?,estado = ?, costo_unitario = ?, cantidad = ?, direccion = ?, activo = ? ,id_caja = ? WHERE ID_Articulo = ?;
        SELECT id_categoria FROM dbo.INMASY_Articulos WHERE ID_Articulo = ?;";
        $params = [
            $articulo['nombre'],
            $articulo['marca'],
            $articulo['modelo'],
            $articulo['serial'],
            $articulo['estado'],
            $articulo['costo_unitario'],
            $articulo['cantidad'],
            $articulo['direccion'],
            $articulo['activo'],
            $articulo['id_caja'],
            $articulo['ID_Articulo'],
            $articulo['ID_Articulo'],
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
        return ['success' => true, 'categoria' => $id];
    }
    public function sacarArticulo($id) {}
    public function pedirArticulo($pedido)
    {

        sqlsrv_begin_transaction($this->conexion);
        try{
        $queryFormula = "INSERT INTO dbo.INMASY_FormulaRetiro(fecha,direccion,num_orden) 
                  VALUES (?,?,?);
                  SELECT SCOPE_IDENTITY() AS id;
                  ";

        $params = [
            $pedido['fecha'],
            $pedido['direccion'],
            $pedido['num_orden'],
        ];

        $stmt = sqlsrv_query($this->conexion, $queryFormula, $params);


        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);

            return ['error' => $e[0]['message']."linea 138"];
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

            return ['error' => $e[0]['message'] ."linea 157"];
        }

        $idInventario = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)['id'];

        sqlsrv_free_stmt($stmt);

        $queryPedido = "INSERT INTO dbo.INMASY_PedidosRetiro(id_inventario,id_formula,nombre_cliente,estado)
                        VALUES (?,?,?,?)";
        $params = [
            $idInventario,
            $idFormula,
            $pedido['nombre_cliente'],
            $pedido['estado']

        ];

        $stmt = sqlsrv_query($this->conexion, $queryPedido, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);

            return ['error' => $e[0]['message']."linea 180"];
        }

        sqlsrv_free_stmt($stmt);

        $query = "UPDATE  a
                  SET a.disponibilidad = 1, uso_equipo = ?
                  FROM dbo.INMASY_Articulos a
                  INNER JOIN dbo.INMASY_Inventario i ON ID_Inventario = ?
                  WHERE a.ID_Articulo = i.id_articulo";
        
        $params = array($pedido['usuario'],$idInventario);

        $stmt = sqlsrv_query($this->conexion,$query,$params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);

            return ['error' => $e[0]['message']."linea 199"];
        }

        sqlsrv_commit($this->conexion);

        return ['success' => true];
        }catch(\Exception $e){
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
