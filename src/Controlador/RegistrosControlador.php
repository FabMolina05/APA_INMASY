<?php
require_once __DIR__ . '/Controller.php';
require_once dirname(__DIR__, 2) . "/src/BL/Registros/RegistroBL.php";

use BL\Registros\RegistrosBL;


class RegistrosControlador extends Controller
{
    private RegistrosBL $RegistroBL;

    public function __construct($conn)
    {
        $this->RegistroBL = new RegistrosBL($conn);
    }

    public function totalRegistros()
    {
        $total = $this->RegistroBL->totalRegistros();

        $this->json(['success'=>true,'data'=> $total]);
    }

    public function totalPorCategoria()
    {
        $total = $this->RegistroBL->totalPorCategoria();

        $this->json(['success'=>true,'data'=> $total]);
    }

    public function totalCapital()
    {
        $total = $this->RegistroBL->totalCapital();

        $this->json(['success'=>true,'data'=> $total]);
    }

    public function index(){
        $this->view('registros/index');
    }
}
