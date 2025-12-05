<?php

use BL\Usuario\UsuarioBL;

class UsuarioControlador extends Controller {
    private UsuarioBL $usuarioBL;

    public function __construct($conn) {
        $this->usuarioBL = new UsuarioBL($conn);
    }

    public function index() {
        $usuarios = $this->usuarioBL->obtenerUsuarios();

        $this->view('usuarios/index', ['usuarios' => $usuarios]);
    }

    public function verUsuario($id) {
        $usuario = $this->usuarioBL->obtenerUsuarioPorId($id);
        $this->view('usuarios/ver', ['usuario' => $usuario]);
    }
}