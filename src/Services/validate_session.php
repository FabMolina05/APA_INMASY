<?php
require_once dirname(__DIR__,2 ). '/src/BL/Usuario/UsuarioBL.php';

use BL\Usuario\UsuarioBL;

class ValidateSession
{

    public static function validate($conn)
    {
        session_start();


        if (!isset($_SESSION['usuario_INMASY'])) {
           
            // se obtiene el id del usaurio de PADDE, en este caso se usa dato quemado para pruebas
            $id_usuario_padde = 34703;

            $usuarioBL = new UsuarioBL($conn);
            $resultado = $usuarioBL->obtenerPermisosUsuario($id_usuario_padde);

            if ($resultado == null) {
                header('Location: /error403.php');
                exit();
            }
            $usuario = $resultado[0];

            $_SESSION['usuario_INMASY'] =  $usuario;
            
            
        }



    }
}
