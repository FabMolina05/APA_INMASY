<?php

namespace ABS\Interfaces\BL;

interface IEntradaBL
{
    public function agregarArticulo($articulo, $adquisicion, $categoria,$almacenamiento);
    public function editarEntrada($entrada);
    public function establecerFecha($id);
    public function obtenerEntradas();
    public function obtenerCategorias();
    public function obtenerProveedores();
    public function obtenerEntradaPorId($id);
}