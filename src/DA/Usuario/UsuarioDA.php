<?php

namespace DA\Usuario;

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/DA/IUsuarioDA.php";

use ABS\Interfaces\DA\IUsuarioDA;
use ABS\Modelos\Usuarios;
use DA\Context\DBContext;

class UsuarioDA implements IUsuarioDA
{
    private $conexion;

    public function __construct($conn)
    {

        $this->conexion = $conn;
    }

    public function obtenerPermisosUsuario($user)
    {
        $query = "SELECT u.ID_Usuario,u.nombre_completo, r.nombre as rol_nombre,r.ID_rol as rol FROM dbo.INMASY_Usuarios u JOIN dbo.INMASY_Roles r ON u.ID_rol = r.ID_rol where u.ID_Usuario = ?";
        $params = [$user];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $usuarios[] = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);


        return $usuarios;
    }

    public function obtenerUsuariosPADDE()
    {
        $query = "SELECT nombre_completo, num_empleado 
                  FROM [PADDE].[dbo].[CNFL_Empleados] 
                  WHERE dependencia = 6311
                  and num_empleado NOT IN (SELECT ID_usuario FROM dbo.INMASY_Usuarios)";
        $stmt = sqlsrv_prepare($this->conexion, $query);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $usuarios = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $usuarios[] = $row;
        }

        return $usuarios;
    }

    public function obtenerUsuarioPorId($user)
    {
        $query = "SELECT * FROM dbo.INMASY_Usuarios WHERE ID_Usuario = ? ";
        $params = [$user];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }

        $usuario = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $usuario[] = $row;
        }

        return $usuario;
    }

    public function agregarUsuario($user)
    {
        $query = "INSERT INTO dbo.INMASY_Usuarios (ID_usuario, nombre_completo, ID_rol, estado) VALUES (?, ?, ?, ?)";
        $params = [
            $user['id'],
            $user['nombre'],
            $user['rol'],
            1
        ];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        return ['success' => true];
    }

    public function actualizarUsuario($user)
    {
        $query = "UPDATE dbo.INMASY_Usuarios SET ID_rol = ?, estado = ? WHERE ID_Usuario = ?";
        $params = [
            $user['rol'],
            $user['estado'],
            $user['id']
        ];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        return ['success' => true];
    }


    public function obtenerRoles()
    {
        $query = "SELECT ID_Rol, nombre FROM dbo.INMASY_Roles";
        $stmt = sqlsrv_prepare($this->conexion, $query);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $roles = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $roles[] = $row;
        }

        return $roles;
    }


    public function obtenerUsuarios()
    {
        $query = "SELECT u.ID_Usuario,u.nombre_completo, r.nombre as rol ,u.estado FROM dbo.INMASY_Usuarios u JOIN dbo.INMASY_Roles r ON u.ID_rol = r.ID_rol ";
        $stmt = sqlsrv_prepare($this->conexion, $query);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $usuarios = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $usuarios[] = $row;
        }
        return $usuarios;
    }
}
