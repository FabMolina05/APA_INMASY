<?php
require_once __DIR__ . '/Controller.php';
require_once dirname(__DIR__,2) . "/src/BL/Salidas/SalidaBL.php";
use BL\Salidas\SalidaBL;


class SalidasControlador extends Controller{
    private SalidaBL $salidaBL;

    public function __construct($conn)
    {
        $this->salidaBL = new SalidaBL($conn);
    }

    public function index(){
        $salidas = $this->salidaBL->obtenerSalidas();

        $this->view('salidas/index',['salidas'=>$salidas]);
    }
}