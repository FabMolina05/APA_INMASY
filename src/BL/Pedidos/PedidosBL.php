<?php

namespace BL\Pedidos;

require_once dirname(__DIR__,3). "/src/ABS/Interfaces/BL/IPedidosBL.php";
require_once dirname(__DIR__,3). "/src/DA/Pedidos/PedidosDA.php";


use DA\Pedidos\PedidosDA;
use ABS\Interfaces\BL\IPedidosBL;
use Exception;

class PedidosBL implements IPedidosBL{
    private $pedidosDA;


    public function __construct($conn)
    {
        $this->pedidosDA = new PedidosDA($conn); 
    }
    public function obtenerPedidosUsuario($usuario){
        try {
            $pedidos = $this->pedidosDA->obtenerPedidosUsuario($usuario);

            return $pedidos;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function denegarPedido($pedido){
        try {
            $resultado = $this->pedidosDA->denegarPedido($pedido);

            return $resultado;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function aceptarPedido($pedido){
        try {
            $resultado = $this->pedidosDA->aceptarPedido($pedido);

            return $resultado;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function detallePedido($pedido){
        try {
            $pedido = $this->pedidosDA->detallePedido($pedido);

            return $pedido;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function obtenerPedidos(){
        try {
            $pedidos = $this->pedidosDA->obtenerPedidos();

            return $pedidos;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}