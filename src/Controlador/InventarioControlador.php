<?php
require_once __DIR__ . '/Controller.php';
require_once dirname(__DIR__,2) . "/src/BL/Inventario/InventarioBL.php";
use BL\Inventario\InventarioBL;


class InventarioControlador extends Controller{
    private InventarioBL $inventarioBL;

    public function __construct($conn)
    {
        $this->inventarioBL = new InventarioBL($conn);
    }

    public function obteneReles(){
        $reles = $this->inventarioBL->obtenerReles();
        $this->view('inventario/reles',['reles'=>$reles]);
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
    public function obtenerArticuloPorId(){
        $id = $_GET['id'];
        $categoria = $_GET['categoria'];
        $articulo = $this->inventarioBL->obtenerArticuloPorId($categoria, $id);
        
        $this->json(['success' => true, 'data' => $articulo]);


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