<?php
require_once __DIR__ . '/../BL/Entradas/EntradaBL.php';
require_once __DIR__ . '/../BL/Usuario/UsuarioBL.php';
require_once __DIR__ . '/Controller.php';
use BL\Entradas\EntradaBL;
use BL\Usuario\UsuarioBL;

class EntradaControlador extends Controller{
    private EntradaBL $entradaBL;
    private UsuarioBL $usuarioBL;

    public function __construct($conn)
    {
        $this->entradaBL = new EntradaBL($conn);
        $this->usuarioBL = new UsuarioBL($conn);
    }

    public function agregarArticulo(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria = $_POST['categoria'];
            
            $adquisicion = [
                'fecha_adquisicion' => $_POST['fecha_adquisicion'],
                'persona_compra' => $_POST['persona_compra'],
                'proveedor' => $_POST['proveedor'],
                'numero_factura' => $_POST['factura'],
                'numero_fondo' => $_POST['numero_fondo'],
                'tipo_pago' => $_POST['tipo_pago'],
                'garantia' => $_POST['garantia'],
            ];

            if($_POST['persona_compra'] == "otros"){
                $adquisicion['persona_compra'] = $_POST['otra_persona'];
            };

            $articuloNuevo = [
                'nombre' => $_POST['nombre'],
                'marca' => $_POST['marca'],
                'modelo' => $_POST['modelo'],
                'serial' => $_POST['serial'],
                'costo_unitario' => $_POST['costo_unitario'],
                'estado' => $_POST['estado'],
                'direccion' => $_POST['direccion'],
                'cantidad' => $_POST['cantidad'],
                'activo' => 1,
                'disponibilidad' => 0,
                'id_caja' => $_POST['caja'],

            ];
            if(isset($_POST['tipo'])){
                $articuloNuevo['atributos'] = json_encode(['tipo' => $_POST['tipo']]);
            };
            if(isset($_POST['peso'])){
                $articuloNuevo['atributos'] = json_encode(['peso' => $_POST['peso']]);
            };
            if(isset($_POST['puertos'])){
                $articuloNuevo['atributos'] = json_encode(['puertos' => $_POST['puertos']]);
            };
            if(isset($_POST['descripcion1'])){
                $articuloNuevo['atributos'] = json_encode(['descripcion1' => $_POST['descripcion1'], 'descripcion2' => $_POST['descripcion2']]);
            };
            if(isset($_POST['corriente'])){
                $articuloNuevo['atributos'] = json_encode(['corriente' => $_POST['corriente'], 'numero' => $_POST['numero']]);
            };
          
            $almacenamiento = ['tipo' => $_POST['almacenamiento']];
           
            if($_POST['almacenamiento'] == 'bodega'){
                $almacenamiento['num_catalogo'] = $_POST['num_catalogo'];
            }

            $resultado = $this->entradaBL->agregarArticulo($articuloNuevo,$adquisicion,$categoria,$almacenamiento);

            if (isset($resultado['error'])) {
                $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);
                return;
            }

            $this->redirect('/inventario/categoria?categoria=reles&id=2' );
        }

        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $categoria = $_GET['categoria'] ?? null;
            $usuarios = $this->usuarioBL->obtenerUsuariosPADDE();
            $categorias = $this->entradaBL->obtenerCategorias();
            $proveedores = $this->entradaBL->obtenerProveedores();
            $this->view('entrada/agregar',['categorias'=>$categorias,'proveedores'=>$proveedores,'usuarios'=>$usuarios,'categoriaSeleccionada'=>$categoria]);
            
        }
    }

    public function editarEntrada(){
        
    }

    public function obtenerEntradas(){
        $entradas = $this->entradaBL->obtenerEntradas();
        $this->view('entrada/index',['entradas'=>$entradas]);
    }
}