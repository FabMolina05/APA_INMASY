<?php

namespace DA\Pedidos;

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/DA/IPedidosDA.php";

use ABS\Interfaces\DA\IPedidosDA;
use DateTime;
use DateTimeZone;


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
                a.cantidad as 'cantidadActual',
                fr.cantidad,
                fr.direccion,
                fr.fecha as fecha,
                fr.num_orden as orden
              FROM dbo.INMASY_PedidosRetiro pr
              LEFT JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = pr.id_persona_taller
              JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = (SELECT i.id_articulo
                                                              FROM dbo.INMASY_Inventario i
                                                              WHERE ID_Inventario = pr.id_inventario)
              JOIN dbo.INMASY_FormulaRetiro fr ON fr.ID_Formula = pr.id_formula
              WHERE pr.id_cliente = ?
              ORDER BY pr.ID_Pedido DESC";

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
                  SET estado = 'DENEGADO',rechazo = ?,id_persona_taller = ?
                  WHERE ID_Pedido = ? ";

        $params = [$pedido['descripcion'], $pedido['encargado'], $pedido['id']];

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

        $params = array($pedido['id']);

        $stmt = sqlsrv_query($this->conexion, $query, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);

            return ['error' => $e . "linea 199"];
        }

        sqlsrv_commit($this->conexion);



        return ['success' => true];
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

        $query = "SELECT cantidad FROM dbo.INMASY_FormulaRetiro
                  WHERE ID_Formula = (SELECT id_formula
                                      FROM dbo.INMASY_PedidosRetiro
                                      WHERE ID_Pedido = ?) ;
                   ";

        $params = array($pedido['id']);

        $stmt = sqlsrv_query($this->conexion, $query, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);
            return ['error' => $e[0]['message']];
        }

        $cantidad = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)['cantidad'];

        sqlsrv_free_stmt($stmt);

        if (!empty($cantidad)) {
            $query = "UPDATE  a
                  SET a.uso_equipo = u.nombre_completo, a.direccion = fr.direccion,a.cantidad = a.cantidad - ?
                  FROM dbo.INMASY_PedidosRetiro pr
                  INNER JOIN dbo.INMASY_Inventario i ON i.ID_Inventario = pr.id_inventario
                  INNER JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = pr.id_cliente
                  INNER JOIN dbo.INMASY_FormulaRetiro fr ON fr.ID_Formula = pr.id_formula
                  INNER JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = i.id_articulo
                  WHERE pr.ID_Pedido = ?";

            $params = array($cantidad, $pedido['id']);

            $stmt = sqlsrv_query($this->conexion, $query, $params);

            if ($stmt == false) {
                $e = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);

                return ['error' => $e[0]['message']];
            }
            $query = "UPDATE  a
                  SET a.uso_equipo = null, a.direccion = '',a.disponibilidad = 0
                  FROM dbo.INMASY_PedidosRetiro pr
                  INNER JOIN dbo.INMASY_Inventario i ON i.ID_Inventario = pr.id_inventario
                  INNER JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = pr.id_cliente
                  INNER JOIN dbo.INMASY_FormulaRetiro fr ON fr.ID_Formula = pr.id_formula
                  INNER JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = i.id_articulo
                  WHERE pr.ID_Pedido = ?";


            $params = array($pedido['id']);

            $stmt = sqlsrv_query($this->conexion, $query, $params);

            if ($stmt == false) {
                $e = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);

                return ['error' => $e[0]['message']];
            }
            sqlsrv_free_stmt($stmt);
        } else {
            $query = "UPDATE  a
                  SET a.uso_equipo = u.nombre_completo, a.direccion = fr.direccion
                  FROM dbo.INMASY_PedidosRetiro pr
                  INNER JOIN dbo.INMASY_Inventario i ON i.ID_Inventario = pr.id_inventario
                  INNER JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = pr.id_cliente
                  INNER JOIN dbo.INMASY_FormulaRetiro fr ON fr.ID_Formula = pr.id_formula
                  INNER JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = i.id_articulo
                  WHERE pr.ID_Pedido = ?";

            $params = array($pedido['id']);

            $stmt = sqlsrv_query($this->conexion, $query, $params);

            if ($stmt == false) {
                $e = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);

                return ['error' => $e[0]['message']];
            }
        }

        sqlsrv_commit($this->conexion);





        return ['success' => true];
    }
    public function detallePedido($pedido)
    {
        $query = "SELECT 
          pr.ID_Pedido as id,
          pr.estado as estado,
          c.nombre_completo as cliente,
          u.nombre_completo as encargado,
          a.nombre as nombre_articulo,
          a.atributos_especificos,
          a.serial,
          a.modelo,
          a.cantidad as 'cantidadActual',
          a.num_articulo as num_articulo,
          a.id_categoria as categoria,
          fr.fecha as fecha,
          fr.direccion as direccion,
          fr.cantidad as cantidad,
          fr.num_orden as orden
      FROM dbo.INMASY_PedidosRetiro pr
      LEFT JOIN dbo.INMASY_Usuarios u 
          ON u.ID_Usuario = pr.id_persona_taller
      LEFT JOIN dbo.INMASY_Usuarios c ON c.ID_Usuario = pr.id_cliente
      LEFT JOIN dbo.INMASY_Inventario i 
          ON i.ID_Inventario = pr.id_inventario
      LEFT JOIN dbo.INMASY_Articulos a 
          ON a.ID_Articulo = i.id_articulo
      LEFT JOIN dbo.INMASY_FormulaRetiro fr 
          ON fr.ID_Formula = pr.id_formula
      WHERE pr.ID_Pedido = ?";

        $params = array($pedido);

        $stmt = sqlsrv_prepare($this->conexion, $query, $params);

        if (!sqlsrv_execute($stmt)) {
            $e = sqlsrv_errors();
            return ['error' => $e[0]['message']];
        }

        $pedido = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);




        return $pedido;
    }
    public function obtenerPedidos()
    {
        $query = "SELECT 
                pr.ID_Pedido as id,
                pr.estado as estado,
                u.nombre_completo as encargado,
                c.nombre_completo as cliente,
                a.nombre as nombre_articulo,
                a.atributos_especificos,
                a.serial,
                a.modelo,
                
                fr.fecha as fecha
              FROM dbo.INMASY_PedidosRetiro pr
              LEFT JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = pr.id_persona_taller
              LEFT JOIN dbo.INMASY_Usuarios c ON c.ID_Usuario = pr.id_cliente
              JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = (SELECT i.id_articulo
                                                              FROM dbo.INMASY_Inventario i
                                                              WHERE ID_Inventario = pr.id_inventario)
              JOIN dbo.INMASY_FormulaRetiro fr ON fr.ID_Formula = pr.id_formula
              ORDER BY pr.ID_Pedido DESC
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
    public function devolverPedido($pedido)
    {
        sqlsrv_begin_transaction($this->conexion);
        $query = "UPDATE  a
                  SET a.uso_equipo = null, a.direccion = null,a.disponibilidad = 0
                  FROM dbo.INMASY_PedidosRetiro pr
                  INNER JOIN dbo.INMASY_Inventario i ON i.ID_Inventario = pr.id_inventario
                  INNER JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = pr.id_cliente
                  INNER JOIN dbo.INMASY_FormulaRetiro fr ON fr.ID_Formula = pr.id_formula
                  INNER JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = i.id_articulo
                  WHERE pr.ID_Pedido = ?";


        $params = array($pedido);

        $stmt = sqlsrv_query($this->conexion, $query, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);

            return ['error' => $e[0]['message']];
        }
        sqlsrv_free_stmt($stmt);

        $query = "UPDATE  dbo.INMASY_PedidosRetiro
                  SET estado = 'DEVUELTO',fecha_devolucion = ?
                  WHERE ID_Pedido = ?";

        $zona = new DateTimeZone('America/Costa_Rica');
        $fechaConZona = new DateTime('now', $zona);
        $fecha_entrega = $fechaConZona->format('Y-m-d H:i:s');
        $params = array($fecha_entrega, $pedido);

        $stmt = sqlsrv_query($this->conexion, $query, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);

            return ['error' => $e[0]['message']];
        }

        sqlsrv_commit($this->conexion);

        return ['success' => true];
    }
    public function editarPedido($pedido)
    {

        sqlsrv_begin_transaction($this->conexion);

        if (($estado = $this->EstadoValido($pedido))['success'] == false) {
            return $estado;
        }

        if (empty($pedido['direccion'])) {
            $query = "UPDATE fr
                SET fr.cantidad = ?, fr.fecha = ? 
                FROM dbo.INMASY_FormulaRetiro fr
                JOIN dbo.INMASY_PedidosRetiro pr ON pr.ID_Pedido = ?
                WHERE fr.ID_Formula =pr.id_formula";

            $params = [
                $pedido['cantidad'],
                $pedido['fecha'],
                $pedido['id_pedido']
            ];
            $stmt = sqlsrv_query($this->conexion, $query, $params);

            if ($stmt == false) {
                $e = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);
                return ['error' => $e[0]['message']];
            }
            sqlsrv_free_stmt($stmt);
        } else {
            $query = "UPDATE fr
                SET fr.direccion = ?, fr.fecha = ? 
                FROM dbo.INMASY_FormulaRetiro fr
                JOIN dbo.INMASY_PedidosRetiro pr ON pr.ID_Pedido = ?
                WHERE fr.ID_Formula =pr.id_formula";

            $params = [
                $pedido['direccion'],
                $pedido['fecha'],
                $pedido['id_pedido']
            ];
            $stmt = sqlsrv_query($this->conexion, $query, $params);

            if ($stmt == false) {
                $e = sqlsrv_errors();
                sqlsrv_rollback($this->conexion);
                return ['error' => $e[0]['message']];
            }
            sqlsrv_free_stmt($stmt);
        }

        sqlsrv_commit($this->conexion);

        return ['success' => true];
    }

    private function EstadoValido($pedido)
    {
        $query = "SELECT estado 
                FROM dbo.INMASY_PedidosRetiro
                WHERE ID_Pedido = ?";

        $params = [

            $pedido['id_pedido']
        ];

        $stmt = sqlsrv_query($this->conexion, $query, $params);

        if ($stmt == false) {
            $e = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);
            return ['success' => false, 'error' => $e[0]['message']];
        }

        $estado = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($estado['estado'] == "DENEGADO") {
            sqlsrv_free_stmt($stmt);
            return ['success' => false, 'error' => "Pedido Denegado"];
        }

        return ['success' => true];
    }
}
