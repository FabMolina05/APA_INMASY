<?php

namespace ABS\Interfaces\DA;

interface IEntradaDA
{
    public function agregarArticulo($articulo, $adquisicion, $categoria);
    public function editarEntrada($entrada);
    public function obtenerEntradas();
    public function obtenerCategorias();
    public function obtenerProveedores();
}
