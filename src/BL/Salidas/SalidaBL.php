<?php

namespace BL\Salidas;
require_once dirname(__DIR__, 3) . "/src/DA/Salidas/SalidaDA.php";

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/BL/ISalidaBL.php";

use ABS\Interfaces\BL\ISalidaBL;
use DA\Salidas\SalidaDA;
use Exception;
class SalidaBL implements ISalidaBL
{
    private $salidaDA;

    public function __construct($conn)
    {
        $this->salidaDA = new SalidaDA($conn);
    }


    public function obtenerSalidas() {
        try {
            $salidas = $this->salidaDA->obtenerSalidas();

            return $salidas;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public function obtenerSalidaPorID($salida) {


    }
}
