<?php

namespace ABS\Interfaces\DA;

interface IInventarioDA
{
    public function obtenerArticulosPorCategoria($categoria);
    public function obtenerArticuloPorId($categoria, $id);
    public function editarArticulo($articulo);
    public function sacarArticulo($id);
    public function pedirArticulo($pedido);
}
