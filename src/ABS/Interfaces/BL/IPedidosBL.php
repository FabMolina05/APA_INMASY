<?php
namespace ABS\Interfaces\BL;

interface IPedidosBL {
    public function obtenerPedidosUsuario($usuario);
    public function denegarPedido($pedido);
    public function aceptarPedido($pedido);
    public function detallePedido($pedido);
    public function obtenerPedidos();
    public function editarPedido($pedido);
    public function devolverPedido($pedido);

}