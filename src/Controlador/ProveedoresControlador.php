<?php
require_once dirname(__DIR__, 2) . "/src/BL/Proveedores/ProveedoresBL.php";

use BL\Proveedores\ProveedoresBL;

class ProveedoresControlador extends Controller
{
    private ProveedoresBL $proveedoresBL;
    public function __construct($conn)
    {
        $this->proveedoresBL = new ProveedoresBL($conn);
    }

    public function index()
    {
        $proveedores = $this->proveedoresBL->obtenerProveedores();
        $this->view('proveedores/index', ['proveedores' => $proveedores]);
    }

    public function agregar()
    {
        $this->view('proveedores/agregar');
    }

    public function agregarProveedor()
    {
        $proveedor = [
            'nombre' => $_POST['nombre'],
            'direccion' => $_POST['direccion'],
            'telefono' => $_POST['telefono'],
            'correo' => $_POST['correo']
        ];
        $resultado = $this->proveedoresBL->agregarProveedor($proveedor);
        $this->redirect('/proveedores/index');
    }
    public function actualizarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $proveedor = [
                'id' => $_POST['ID_Proveedor'],
                'nombre' => $_POST['nombre'],
                'direccion' => $_POST['direccion'],
                'telefono' => $_POST['telefono'],
                'correo' => $_POST['correo']
            ];

            $resultado = $this->proveedoresBL->actualizarProveedor($proveedor);

            if (isset($resultado['error'])) {
                $this->json($resultado, 500);
            } else {
                $this->redirect('/proveedores/index');
            }
        }
    }

    public function obtenerProveedorPorId()
    {
        $id = $_GET['id'];
        $proveedor = $this->proveedoresBL->obtenerProveedorPorId($id);



        $this->json(['success' => true, 'data' => $proveedor]);
    }
}
