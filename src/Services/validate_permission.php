<?php
require_once dirname(__DIR__, 2) . '/src/BL/Usuario/UsuarioBL.php';

use BL\Usuario\UsuarioBL;

class ValidatePermissions
{


    public static function validate($request, $conn)
    {
        $usuarioBL = new UsuarioBL($conn);


        $lista_permisos = [
            [
                'request' => '/',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/usuarios/index',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/usuarios/agregar',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/usuarios/guardar',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/usuarios/actualizar',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/inventario/categoria',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/inventario/obtenerArticuloPorId',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/inventario/actualizar',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/inventario/sacarArticulo',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/inventario/pedirArticulo',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/entrada/agregarArticulo',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/entrada/reponer',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/entrada/index',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/entrada/obtenerEntradaPorId',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/entrada/establecerFecha',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/entrada/actualizar',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/pedidos/listaPedidos',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/pedidos/index',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/pedidos/aceptar',
                'roles' => ['1', '2', '3']
            ],
            [
                'request' => '/pedidos/denegar',
                'roles' => ['1', '2', '3']
            ],
            [
                'request' => '/pedidos/detalle',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/pedidos/editarPedido',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/pedidos/devolver',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/error404',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/error403',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/error501',
                'roles' => ['1', '2', '3', '4']
            ],
            [
                'request' => '/proveedores/index',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/proveedores/agregar',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/proveedores/agregarProveedor',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/proveedores/actualizar',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/proveedores/desactivar',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/proveedores/obtenerProveedorPorId',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/salidas/index',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/salidas/obtenerSalidaPorId',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/registros/totalRegistros',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/registros/totalCapital',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/registros/totalPorCategoria',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/registros/index',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/bitacora/index',
                'roles' => ['1', '2']
            ],
            [
                'request' => '/bitacora/detalle',
                'roles' => ['1', '2']
            ],
        ];
        $rqExist = false;

        if (isset($_SESSION['usuario_INMASY'])) {
            $resultado = $usuarioBL->obtenerPermisosUsuario($_SESSION['usuario_INMASY']['ID_Usuario']);

            $rol = $resultado[0]['rol'];
            foreach ($lista_permisos as $rq) {

                if ($rq['request'] == $request) {

                    $rqExist = true;
                    if (!in_array($rol, $rq['roles'])) {
                        header('Location: /error403');
                        session_destroy();

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
