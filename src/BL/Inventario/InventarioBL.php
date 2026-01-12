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

    public function obtenerArticulosPorCategoria($categoria)
    {
        try {
            $reles = $this->inventarioDA->obtenerArticulosPorCategoria($categoria);

            return $reles;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    
    public function obtenerArticuloPorId($categoria, $id){
        try {
            $articulo = $this->inventarioDA->obtenerArticuloPorId($categoria, $id);

            return $articulo;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function editarArticulo($articulo){
        try {
            $resultado = $this->inventarioDA->editarArticulo($articulo);

            return $resultado;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function sacarArticulo($id){

    }
    public function pedirArticulo($id){

    }
    

}