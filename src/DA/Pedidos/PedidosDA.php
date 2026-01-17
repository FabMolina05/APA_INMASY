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



        return ['success' => true];;
    }
    public function aceptarPedido($pedido)
    {
        sqlsrv_begin_transaction($this->conexion);
        $query = "UPDATE dbo.INMASY_PedidosRetiro
                  SET estado = 'ACEPTADO'
                  WHERE ID_Pedido = ? ";

        $params = array($pedido);

        $stmt = sqlsrv_query($this->conexion, $query, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            return ['error' => $e[0]['message']];
        }



        return ['success' => true];;
    }
    public function detallePedido($pedido) {
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
                fr.fecha as fecha,
                fr.direccion as direccion,
                fr.num_orden as orden
              FROM dbo.INMASY_PedidosRetiro pr
              JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = pr.id_persona_taller
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
}
