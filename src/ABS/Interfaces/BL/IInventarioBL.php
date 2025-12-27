<?php
namespace ABS\Interfaces\BL;

interface IInventarioBL{
    public function obtenerReles();
    public function obtenerEquipoElectronico();
    public function obtenerCables();
    public function obtenerComunicaciones();
    public function obtenerGabinetes();
    public function obtenerTarjetas();
    public function obtenerOtros();
    public function obtenerArticuloPorId($categoria, $id);
    public function editarArticulo($categoria, $id);
    public function sacarArticulo($id);
    public function pedirArticulo($id);
    public function agregarArticulo();
}