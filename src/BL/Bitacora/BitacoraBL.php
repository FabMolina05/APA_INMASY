<?php

namespace BL\Bitacora;

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/BL/IBitacoraBL.php";
require_once dirname(__DIR__, 3) . "/src/DA/Bitacora/BitacoraDA.php";

use ABS\Interfaces\BL\IBitacoraBL;
use DA\Bitacora\BitacoraDA;
use Exception;

class BitacoraBL implements IBitacoraBL
{
    private $BitacoraDA;

    public function __construct($conn)
    {
        $this->BitacoraDA = new BitacoraDA($conn);
    }
    public function obtenerBitacora()
    {
        try {
            $bitacora = $this->BitacoraDA->obtenerBitacora();

            return $bitacora;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function obtenerBitacoraPorId($id) {
         try {
            $bitacora = $this->BitacoraDA->obtenerBitacoraPorId($id);

            return $bitacora;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function registrarBitacora($bitacora) {
         try {
           $this->BitacoraDA->registrarBitacora($bitacora);

            
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
