<?php

namespace ABS\Interfaces\DA;

interface IEntradaDA
{
    public function agregarArticulo($articulo, $adquisicion, $categoria, $almacenamiento);
    public function editarEntrada($entrada);
    public function obtenerEntradas();
    public function establecerFecha($id);
    public function obtenerCategorias();
    public function obtenerProveedores();
    public function obtenerEntradaPorID($id);
}
