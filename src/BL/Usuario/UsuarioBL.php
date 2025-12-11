<?php
namespace BL\Usuario;

require_once dirname(__DIR__,3) . "/src/ABS/Interfaces/BL/IUsuarioBL.php";
require_once dirname(__DIR__,3) . "/src/DA/Usuario/UsuarioDA.php";
use ABS\Interfaces\BL\IUsuarioBL;
use DA\Usuario\UsuarioDA;
use Exception;

class UsuarioBL implements IUsuarioBL
{
    private $usuarioDA;

    public function __construct($conn)
    {
        $this->usuarioDA = new UsuarioDA($conn);
    }

    public function obtenerPermisosUsuario($user)
    {
        return $this->usuarioDA->obtenerPermisosUsuario($user);
    }

    public function obtenerUsuariosPADDE()
    {
        return $this->usuarioDA->obtenerUsuariosPADDE();
    }

    public function obtenerUsuarioPorId($user)
    {
        return $this->usuarioDA->obtenerUsuarioPorId($user);
    }

    public function agregarUsuario($user)
    {
        return $this->usuarioDA->agregarUsuario($user);
    }

    public function actualizarUsuario($user)
    {
        return $this->usuarioDA->actualizarUsuario($user);
    }

    public function obtenerRol($user)
    {
        return $this->usuarioDA->obtenerRol($user);
    }

    public function obtenerUsuarios()
    {
        try {
            $users = $this->usuarioDA->obtenerUsuarios();

            return $users;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
