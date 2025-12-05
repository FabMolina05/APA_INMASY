<?php

namespace DA\Usuario;
use ABS\Interfaces\DA\IUsuarioDA;
use ABS\Modelos\Usuarios;
use DA\Context\DBContext;

class UsuarioDA implements IUsuarioDA {
    private $conexion;

    public function __construct($conn)
    {
        
        $this->conexion = $conn;
    }

    public function obtenerPermisosUsuario($user) {
        // Implementación del métod
    }

    public function obtenerUsuariosPADDE() {
        
        
    }

    public function obtenerUsuarioPorId($user) {
        // Implementación del método
    }

    public function agregarUsuario($user) {
        // Implementación del método
    }

    public function actualizarUsuario($user) {
        // Implementación del método
    }

    public function obtenerRol($user) {
        // Implementación del método
    }

    public function obtenerUsuarios() {
        $query = "SELECT ID_Usuario, ID_Rol, nombre_completo FROM dbo.INMASY_Usuarios";
        $stmt = sqlsrv_prepare($this->conexion, $query);
        sqlsrv_execute($stmt);
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        
        
    }
}