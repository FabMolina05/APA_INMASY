<?php
namespace ABS\Interfaces\DA;

interface IBitacoraDA{
    public function obtenerBitacora();
    public function obtenerBitacoraPorId($id);
    public function registrarBitacora($bitacora);
}