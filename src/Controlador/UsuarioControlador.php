<?php
require_once dirname(__DIR__,2) . "/src/BL/Usuario/UsuarioBL.php";
use BL\Usuario\UsuarioBL;

class UsuarioControlador extends Controller {
    private UsuarioBL $usuarioBL;

    public function __construct($conn) {
        $this->usuarioBL = new UsuarioBL($conn);
    }

    public function index() {
        $usuarios = $this->usuarioBL->obtenerUsuarios();
        $roles = $this->usuarioBL->obtenerRoles();
        $this->view('usuarios/index', ['usuarios' => $usuarios,'roles' => $roles]);
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