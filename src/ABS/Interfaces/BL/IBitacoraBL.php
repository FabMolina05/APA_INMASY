<?php
namespace ABS\Interfaces\BL;

interface IBitacoraBL{
    public function obtenerBitacora();
    public function obtenerBitacoraPorId($id);
    public function registrarBitacora($bitacora);
}