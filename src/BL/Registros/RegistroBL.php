<?php

namespace BL\Registros;

require_once dirname(__DIR__, 3) . "/src/DA/Registros/RegistrosDA.php";

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/BL/IRegistrosBL.php";

use ABS\Interfaces\BL\IRegistrosBL;
use DA\Registros\RegistrosDA;
use Exception;

class RegistrosBL implements IRegistrosBL
{
    private $RegistrosDA;

    public function __construct($conn)
    {
        $this->RegistrosDA = new RegistrosDA($conn);
    }

    public function totalRegistros() {
         try {
            $total = $this->RegistrosDA->totalRegistros();

            return $total;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function totalPorCategoria() {
          try {
            $total = $this->RegistrosDA->totalPorCategoria();

            return $total;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function totalCapital() {
          try {
            $total = $this->RegistrosDA->totalCapital();

            return $total;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
