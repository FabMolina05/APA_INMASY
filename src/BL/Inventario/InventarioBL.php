<?php

namespace BL\Inventario;

require_once dirname(__DIR__, 3) . "/src/DA/Inventario/InventarioDA.php";
require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/BL/IInventarioBL.php";

use DA\Inventario\InventarioDA;
use ABS\Interfaces\BL\IInventarioBL;
use Exception;

class InventarioBL implements IInventarioBL{
    private $inventarioDA;

    public function __construct($conn)
    {
        $this->inventarioDA = new InventarioDA($conn);
    }

    public function obtenerReles(){
        try {
            $reles = $this->inventarioDA->obtenerReles();

            return $reles;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function obtenerEquipoElectronico(){

    }
    public function obtenerCables(){

    }
    public function obtenerComunicaciones(){

    }
    public function obtenerGabinetes(){

    }
    public function obtenerTarjetas(){

    }
    public function obtenerOtros(){

    }
    public function obtenerArticuloPorId($categoria, $id){
        try {
            $articulo = $this->inventarioDA->obtenerArticuloPorId($categoria, $id);

            return $articulo;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function editarArticulo($categoria, $id){

    }
    public function sacarArticulo($id){

    }
    public function pedirArticulo($id){

    }
    public function agregarArticulo(){

    }

}