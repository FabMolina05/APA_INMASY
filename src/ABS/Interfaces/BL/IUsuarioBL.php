<?php
namespace ABS\Interfaces\BL;

interface IUsuarioBL {
    public function obtenerPermisosUsuario($user);
    public function obtenerUsuariosPADDE();
    public function agregarUsuario($user);
    public function actualizarUsuario($user);
    public function obtenerUsuarios();
    public function obtenerRoles();
}