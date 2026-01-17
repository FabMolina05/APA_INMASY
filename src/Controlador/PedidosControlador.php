<?php

require_once dirname(__DIR__,2) . "/src/BL/Pedidos/PedidosBL.php";
use BL\Pedidos\PedidosBL;

class PedidosControlador extends Controller {
    private PedidosBL $PedidosBL;

    public function __construct($conn) {
        $this->PedidosBL = new PedidosBL($conn);
    }

    public function index() {

        if($_SESSION['usuario_INMASY']['rol']==1){
            $PedidosGenerales = $this->PedidosBL->obtenerPedidos();
        }
        $PedidosUsuario = $this->PedidosBL->obtenerPedidosUsuario($_SESSION['usuario_INMASY']['ID_Usuario']);
        $this->view('pedidos/index', [(isset($PedidosGenerales))?? 'pedidosGenerales' => $PedidosGenerales,'pedidosUsuario' => $PedidosUsuario]);
    }

    public function agregarUsuario() {
        $usuarios = $this->usuarioBL->obtenerUsuariosPADDE();
        $roles = $this->usuarioBL->obtenerRoles();
        $this->view('usuarios/agregar', ['usuario' => $usuarios, 'roles' => $roles]);
        
    }

    public function guardarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['usuarioPADDE'];
            $nombre = $_POST['nombreUsuarioPADDE'];
            $rol = $_POST['rol'];
            
            $nuevoUsuario = [
                'id' => $id,
                'nombre' => $nombre,
                'rol' => $rol
            ];

            $resultado = $this->usuarioBL->agregarUsuario($nuevoUsuario);

            if (isset($resultado['error'])) {
                $this->json($resultado,500);
            } else {
                $this->redirect('/usuarios/index');
                exit();
            }
        }
    }
    public function actualizarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['ID_Usuario'];
            $rol = $_POST['rol'];
            $estado = $_POST['estado'];
            
            $usuarioActualizado = [
                'id' => $id,
                'rol' => $rol,
                'estado' => $estado
            ];

            $resultado = $this->usuarioBL->actualizarUsuario($usuarioActualizado);

            if (isset($resultado['error'])) {
                $this->json($resultado,500);
            } else {
                $this->redirect('/usuarios/index');
            }
        }
    }
}