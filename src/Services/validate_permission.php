<?php

class ValidatePermissions
{


    public static function validate($request)
    {


        $lista_permisos = [
            [
                'request' => '/',
                'roles' => ['1','2','3']
            ],
            [
                'request' => '/usuarios/index',
                'roles' => ['1']
            ],
            [
                'request' => '/usuarios/agregar',
                'roles' => ['1']
            ],
            [
                'request' => '/usuarios/guardar',
                'roles' => ['1']
            ],
            [
                'request' => '/usuarios/actualizar',
                'roles' => ['1']
            ],
            [
                'request' => '/inventario/comunicaciones',
                'roles' => ['1']
            ],
            [
                'request' => '/error404',
                'roles' => ['1','2','3']
            ],
             [
                'request' => '/error403',
                'roles' => ['1','2','3']
            ],

        ];
        $rqExist = false;

        if (isset($_SESSION['usuario_INMASY'])) {
            $rol = $_SESSION['usuario_INMASY']['rol'];
            foreach ($lista_permisos as $rq) {
                
                if ($rq['request'] == $request) {
                    
                    $rqExist = true;
                    if (!in_array($rol, $rq['roles'])) {
                        header('Location: /error403');

                        exit();
                    }
                }
            }

            
        }
        if (!$rqExist) {
               
                header('Location: /error404');
                exit;
            }
    }
}
