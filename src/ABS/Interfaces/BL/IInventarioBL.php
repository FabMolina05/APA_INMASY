<?php
namespace ABS\Interfaces\BL;

interface IInventarioBL{
     public function obtenerArticulosPorCategoria($categoria);
    public function obtenerArticuloPorId($categoria, $id);
    public function editarArticulo($articulo);
    public function sacarArticulo($id,$motivo);
    public function pedirArticulo($pedido);
}