<?php

namespace DA\Pedidos;

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/DA/IPedidosDA.php";

use ABS\Interfaces\DA\IPedidosDA;


class PedidosDA implements IPedidosDA
{
    private $conexion;

    public function __construct($conn)
    {
        $this->conexion = $conn;
    }


    public function obtenerPedidosUsuario($usuario)
    {
        $query = "SELECT 
                pr.ID_Pedido as id,
                pr.estado as estado,
                u.nombre_completo as encargado,
                a.nombre as nombre_articulo,
                a.serial,
                a.modelo,
                fr.fecha as fecha,
                fr.num_orden as orden
              FROM dbo.INMASY_PedidosRetiro pr
              LEFT JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = pr.id_persona_taller
              JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = (SELECT i.id_articulo
                                                              FROM dbo.INMASY_Inventario i
                                                              WHERE ID_Inventario = pr.id_inventario)
              JOIN dbo.INMASY_FormulaRetiro fr ON fr.ID_Formula = pr.id_formula
              WHERE a.uso_equipo = ?";

        $params = array($usuario);

        $stmt = sqlsrv_prepare($this->conexion, $query, $params);

        if (!sqlsrv_execute($stmt)) {
            $e = sqlsrv_errors();
            return ['error' => $e[0]['message']];
        }

        $pedidos = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $pedidos[] = $row;
        }

        return $pedidos;
    }
    public function denegarPedido($pedido)
    {
        sqlsrv_begin_transaction($this->conexion);
        $query = "UPDATE dbo.INMASY_PedidosRetiro
                  SET estado = 'DENEGADO'
                  WHERE ID_Pedido = ? ";

        $params = array($pedido);

        $stmt = sqlsrv_query($this->conexion, $query, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            return ['error' => $e[0]['message']];
        }
        sqlsrv_free_stmt($stmt);



        $query = "UPDATE a
                SET a.disponibilidad = 0,
                    a.uso_equipo = NULL
                FROM dbo.INMASY_Articulos a
                INNER JOIN dbo.INMASY_Inventario i
                    ON i.id_articulo = a.ID_Articulo
                INNER JOIN dbo.INMASY_PedidosRetiro pr
                    ON pr.id_inventario = i.ID_Inventario
                WHERE pr.ID_Pedido = ?";

        $params = array($pedido);

        $stmt = sqlsrv_query($this->conexion, $query, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);

            return ['error' => $e[0]['message'] . "linea 199"];
        }

        sqlsrv_commit($this->conexion);



        return ['success' => true];;
    }
    public function aceptarPedido($pedido)
    {
        sqlsrv_begin_transaction($this->conexion);
        $query = "UPDATE dbo.INMASY_PedidosRetiro
                  SET estado = 'ACEPTADO',id_persona_taller = ?
                  WHERE ID_Pedido = ? ;
                   ";

        $params = array($pedido['encargado'], $pedido['id']);

        $stmt = sqlsrv_query($this->conexion, $query, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);
            return ['error' => $e[0]['message']];
        }
        sqlsrv_free_stmt($stmt);

        $query = "UPDATE dbo.INMASY_FormulaRetiro
                  SET num_orden = ?
                  WHERE ID_Formula = (SELECT id_formula
                                      FROM dbo.INMASY_PedidosRetiro
                                      WHERE ID_Pedido = ?) ;
                   ";

        $params = array($pedido['num_orden'], $pedido['id']);

        $stmt = sqlsrv_query($this->conexion, $query, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);
            return ['error' => $e[0]['message']];
        }
        sqlsrv_free_stmt($stmt);



        sqlsrv_commit($this->conexion);





        return ['success' => true];;
    }
    public function detallePedido($pedido)
    {
        $query = "SELECT 
                pr.ID_Pedido as id,
                pr.estado as estado,
                pr.nombre_cliente as cliente,
                u.nombre_completo as encargado,
                a.nombre as nombre_articulo,
                a.atributos_especificos,
                a.serial,
                a.modelo,
                fr.fecha as fecha,
                fr.direccion as direccion,
                fr.num_orden as orden
              FROM dbo.INMASY_PedidosRetiro pr
              JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = pr.id_persona_taller
              JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = (SELECT i.id_articulo
                                                              FROM dbo.INMASY_Inventario i
                                                              WHERE ID_Inventario = pr.id_inventario)
              JOIN dbo.INMASY_FormulaRetiro fr ON fr.ID_Formula = pr.id_formula
              WHERE e.ID_Pedido = ?";

        $params = array($pedido);

        $stmt = sqlsrv_prepare($this->conexion, $query, $params);

        if (!sqlsrv_execute($stmt)) {
            $e = sqlsrv_errors();
            return ['error' => $e[0]['message']];
        }

        $pedido = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $pedido[] = $row;
        }

        return $pedido;
    }
    public function obtenerPedidos()
    {
        $query = "SELECT 
                pr.ID_Pedido as id,
                pr.estado as estado,
                u.nombre_completo as encargado,
                pr.nombre_cliente as cliente,
                a.nombre as nombre_articulo,
                a.atributos_especificos,
                a.serial,
                a.modelo,
                fr.fecha as fecha
              FROM dbo.INMASY_PedidosRetiro pr
              LEFT JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = pr.id_persona_taller
              JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = (SELECT i.id_articulo
                                                              FROM dbo.INMASY_Inventario i
                                                              WHERE ID_Inventario = pr.id_inventario)
              JOIN dbo.INMASY_FormulaRetiro fr ON fr.ID_Formula = pr.id_formula
              ";



        $stmt = sqlsrv_prepare($this->conexion, $query);

        if (!sqlsrv_execute($stmt)) {
            $e = sqlsrv_errors();
            return ['error' => $e[0]['message']];
        }

        $pedidos = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $pedidos[] = $row;
        }

        return $pedidos;;
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
