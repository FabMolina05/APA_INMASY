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
        try {
            $users = $this->usuarioDA->obtenerUsuariosPADDE();

            return $users;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function obtenerUsuarioPorId($user)
    {
        try {
            $user = $this->usuarioDA->obtenerUsuarioPorId($user);
            return $user;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function agregarUsuario($user)
    {
        try {
            $resultado = $this->usuarioDA->agregarUsuario($user);

            return $resultado;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actualizarUsuario($user)
    {
        try {
            $resultado = $this->usuarioDA->actualizarUsuario($user);

            return $resultado;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

 
    public function obtenerRoles()
    {
        try {
            $roles = $this->usuarioDA->obtenerRoles();

            return $roles;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
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
