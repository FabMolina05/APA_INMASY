<?php
require_once dirname(__DIR__, 2) . "/src/BL/Proveedores/ProveedoresBL.php";
require_once dirname(__DIR__, 2) . "/src/BL/Bitacora/BitacoraBL.php";

use BL\Proveedores\ProveedoresBL;
use BL\Bitacora\BitacoraBL;


class ProveedoresControlador extends Controller
{
    private ProveedoresBL $proveedoresBL;
    private BitacoraBL $bitacoraBL;

    public function __construct($conn)
    {
        $this->proveedoresBL = new ProveedoresBL($conn);
        $this->bitacoraBL = new BitacoraBL($conn);
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

        if (isset($resultado['error'])) {
            $this->bitacoraBL->registrarBitacora([
                'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                'categoria' => 'PROVEEDORES',
                'fecha' => $this->registrarFechaHora(),
                'descripcion' => "Insertar proveedor error: {$resultado['error']}",
                'accion' => 'INSERT',
                'estado' => 'ERROR'
            ]);
            $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);

            return;
        }
        $this->bitacoraBL->registrarBitacora([
            'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
            'categoria' => 'PROVEEDORES',
            'fecha' => $this->registrarFechaHora(),
            'descripcion' => "Insertar proveedor ID: {$resultado['id']}",
            'accion' => 'INSERT',
            'estado' => 'SUCCESS'
        ]);
        $this->redirect('/proveedores/index');
    }
    public function actualizarProveedor()
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
                $this->bitacoraBL->registrarBitacora([
                    'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                    'categoria' => 'PROVEEDORES',
                    'fecha' => $this->registrarFechaHora(),
                    'descripcion' => "Actualizar proveedor error: {$resultado['error']}",
                    'accion' => 'UPDATE',
                    'estado' => 'ERROR'
                ]);
                $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);

                return;
            } else {
                $this->bitacoraBL->registrarBitacora([
                    'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                    'categoria' => 'PROVEEDORES',
                    'fecha' => $this->registrarFechaHora(),
                    'descripcion' => "Actualizar proveedor ID: {$proveedor['id']}",
                    'accion' => 'UPDATE',
                    'estado' => 'SUCCESS'
                ]);
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
    private function registrarFechaHora()
    {
        $zona = new DateTimeZone('America/Costa_Rica');
        $fechaConZona = new DateTime('now', $zona);
        return $fechaConZona->format('Y-m-d H:i:s');
    }
}
