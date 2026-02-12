<?php
require_once dirname(__DIR__, 2) . "/src/BL/Usuario/UsuarioBL.php";
require_once dirname(__DIR__, 2) . "/src/BL/Bitacora/BitacoraBL.php";

use BL\Usuario\UsuarioBL;
use BL\Bitacora\BitacoraBL;

class UsuarioControlador extends Controller
{
    private UsuarioBL $usuarioBL;
    private BitacoraBL $bitacoraBL;

    public function __construct($conn)
    {
        $this->usuarioBL = new UsuarioBL($conn);
        $this->bitacoraBL = new BitacoraBL($conn);
    }

    public function index()
    {
        $usuarios = $this->usuarioBL->obtenerUsuarios();
        $roles = $this->usuarioBL->obtenerRoles();
        $this->view('usuarios/index', ['usuarios' => $usuarios, 'roles' => $roles]);
    }

    public function agregarUsuario()
    {
        $usuarios = $this->usuarioBL->obtenerUsuariosPADDE();
        $roles = $this->usuarioBL->obtenerRoles();
        $this->view('usuarios/agregar', ['usuario' => $usuarios, 'roles' => $roles]);
    }

    public function guardarUsuario()
    {
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
                $this->bitacoraBL->registrarBitacora([
                    'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                    'categoria' => 'USUARIOS',
                    'fecha' => $this->registrarFechaHora(),
                    'descripcion' => "Insertar usuario error: {$resultado['error']}",
                    'accion' => 'INSERT',
                    'estado' => 'ERROR'
                ]);
                $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);

                return;
            } else {
                $this->bitacoraBL->registrarBitacora([
                    'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                    'categoria' => 'USUARIOS',
                    'fecha' => $this->registrarFechaHora(),
                    'descripcion' => "Insertar usuario ID: {$resultado['id']}",
                    'accion' => 'INSERT',
                    'estado' => 'SUCCESS'
                ]);
                $this->redirect('/usuarios/index');
                exit();
            }
        }
    }
    public function actualizarUsuario()
    {
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
                $this->bitacoraBL->registrarBitacora([
                    'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                    'categoria' => 'USUARIOS',
                    'fecha' => $this->registrarFechaHora(),
                    'descripcion' => "Actualizar usuario error: {$resultado['error']}",
                    'accion' => 'UPDATE',
                    'estado' => 'ERROR'
                ]);
                $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);

                return;
            } else {
                 $this->bitacoraBL->registrarBitacora([
                    'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                    'categoria' => 'USUARIOS',
                    'fecha' => $this->registrarFechaHora(),
                    'descripcion' => "Actualizar usuario ID: {$usuarioActualizado['id']}",
                    'accion' => 'UPDATE',
                    'estado' => 'SUCCESS'
                ]);
                $this->redirect('/usuarios/index');
            }
        }
    }

    private function registrarFechaHora()
    {
        $zona = new DateTimeZone('America/Costa_Rica');
        $fechaConZona = new DateTime('now', $zona);
        return $fechaConZona->format('Y-m-d H:i:s');
    }
}
