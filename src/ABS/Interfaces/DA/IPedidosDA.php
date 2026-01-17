<?php
namespace ABS\Interfaces\DA;

interface IPedidosDA {
    public function obtenerPedidosUsuario($usuario);
    public function denegarPedido($pedido);
    public function aceptarPedido($pedido);
    public function detallePedido($pedido);
    public function obtenerPedidos();
}