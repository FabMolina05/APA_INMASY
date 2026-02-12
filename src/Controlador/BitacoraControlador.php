<?php
require_once dirname(__DIR__,2) . "/src/BL/Bitacora/BitacoraBL.php";
use BL\Bitacora\BitacoraBL;

class BitacoraControlador extends Controller {
    private BitacoraBL $BitacoraBL;

    public function __construct($conn) {
        $this->BitacoraBL = new BitacoraBL($conn);
    }

    public function index() {
        $bitacoras = $this->BitacoraBL->obtenerBitacora();
       
        $this->view('bitacora/index', ['bitacoras' => $bitacoras]);
    }
}