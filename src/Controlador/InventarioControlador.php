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
        $articuloActualizado = [
                'nombre' => $_POST['nombre'],
                'marca' => $_POST['marca'],
                'modelo' => $_POST['modelo'],
                'serial' => $_POST['serial'],
                'costo_unitario' => $_POST['costo_unitario'],
                'estado' => $_POST['estado'],
                'direccion' => $_POST['direccion'],
                'cantidad' => $_POST['cantidad'],
                'activo' => $_POST['activo'],
                'disponibilidad' => 0,
                'ID_Articulo' => $_POST['ID_Articulo'],

            ];
         if(isset($_POST['tipo'])){
                $articuloActualizado['atributos'] = json_encode(['tipo' => $_POST['tipo']]);
            };
            if(isset($_POST['peso'])){
                $articuloActualizado['atributos'] = json_encode(['peso' => $_POST['peso']]);
            };
            if(isset($_POST['puertos'])){
                $articuloActualizado['atributos'] = json_encode(['puertos' => $_POST['puertos']]);
            };
            if(isset($_POST['descripcion1'])){
                $articuloActualizado['atributos'] = json_encode(['descripcion1' => $_POST['descripcion1'], 'descripcion2' => $_POST['descripcion2']]);
            };
            if(isset($_POST['corriente'])){
                $articuloActualizado['atributos'] = json_encode(['corriente' => $_POST['corriente'], 'numero' => $_POST['numero']]);
            }; 
          
        $resultado = $this->inventarioBL->editarArticulo($articuloActualizado);
        $this->redirect('/inventario/categoria?categoria=' . $categoria. '&id=' . $resultado['categoria']);
    }

    public function sacarArticulo($id){

    }
    public function pedirArticulo($id){

    }
   


}