<?php 
namespace ABS\Interfaces\DA;

interface IUsuarioDA {
    public function obtenerPermisosUsuario($user);
    public function obtenerUsuariosPADDE();
    public function obtenerUsuarioPorId($user);
    public function agregarUsuario($user);
    public function actualizarUsuario($user);
    public function obtenerUsuarios();
    public function obtenerRoles();

}



?>