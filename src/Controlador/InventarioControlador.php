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

    public function obtenerArticulosPorCategoria($id,$categoria){
        $articulos = $this->inventarioBL->obtenerArticulosPorCategoria($id);
        $this->view('inventario/'.$categoria,['articulos'=>$articulos]);
    }
    
    public function obtenerArticuloPorId(){
        $id = $_GET['id'];
        $categoria = $_GET['categoria'];
        $articulo = $this->inventarioBL->obtenerArticuloPorId($categoria, $id);
        
        $this->json(['success' => true, 'data' => $articulo]);


    }
    public function editarArticulo(){
       $categoria = $_POST['categoria'];
        $articuloActualizado = $_POST;
        $this->inventarioBL->editarArticulo($articuloActualizado);

        $this->redirect('/inventario/' . $categoria);

    }
    public function sacarArticulo($id){

    }
    public function pedirArticulo($id){

    }
   


}