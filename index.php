<?php
require_once __DIR__ . '/src/DA/DBContext.php';

require_once __DIR__ . '/src/Controlador/IndexControlador.php';
require_once __DIR__ . '/src/Controlador/UsuarioControlador.php';
require_once __DIR__ . '/src/Controlador/InventarioControlador.php';
require_once __DIR__ . '/src/Controlador/EntradaControlador.php';
require_once __DIR__ . '/src/Controlador/PedidosControlador.php';
require_once __DIR__ . '/src/Controlador/ProveedoresControlador.php';
require_once __DIR__ . '/src/Controlador/SalidasControlador.php';
require_once __DIR__ . '/src/Controlador/RegistrosControlador.php';

require_once __DIR__ . '/src/Services/validate_session.php';
require_once __DIR__ . '/src/Services/validate_permission.php';

use DA\DBContext;

$dbContext = new DBContext();
$conn = $dbContext->getConnection();

$indexController = new IndexControlador();
$usuarioController = new UsuarioControlador($conn);
$inventarioController = new InventarioControlador($conn);
$entradaController = new EntradaControlador($conn);
$pedidosController = new PedidosControlador($conn);
$proveedoresController = new ProveedoresControlador($conn);
$salidasControlador = new SalidasControlador($conn);
$registrosControlador = new RegistrosControlador($conn);


$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');
$request = str_replace('/index.php', '', $request);
$request = $request ?: '/';

ValidateSession::validate($conn);
ValidatePermissions::validate($request);

ob_start();

include __DIR__ . '/Web/components/Header.php';
include __DIR__ . '/Web/components/Sidebar.php';



switch ($request) {
    case '/':
        $indexController->index();
        break;
    case '/usuarios/index':
        $usuarioController->index();
        break;
    case '/usuarios/agregar':
        $usuarioController->agregarUsuario();
        break;
    case '/usuarios/guardar':
        $usuarioController->guardarUsuario();
        break;
    case '/usuarios/actualizar':
        $usuarioController->actualizarUsuario();
        break;
    case '/inventario/categoria':
        $inventarioController->obtenerArticulosPorCategoria($_GET['id'], $_GET['categoria']);
        break;
    case '/inventario/obtenerArticuloPorId':
        $inventarioController->obtenerArticuloPorId();
        break;
    case '/inventario/actualizar':
        $inventarioController->editarArticulo();
        break;
    case '/inventario/sacarArticulo':
        $inventarioController->sacarArticulo();
        break;
    case '/inventario/pedirArticulo':
        $inventarioController->pedirArticulo();
        break;
    case '/entrada/agregarArticulo':
        $entradaController->agregarArticulo();
        break;
    case '/entrada/index':
        $entradaController->obtenerEntradas();
        break;
    case '/entrada/obtenerEntradaPorId':
        $entradaController->obtenerEntradaPorId();
        break;
    case '/entrada/establecerFecha':
        $entradaController->establecerFecha();
        break;
    case '/entrada/actualizar':
        $entradaController->editarEntrada();
        break;
    case '/pedidos/index':
        $pedidosController->index();
        break;
    case '/pedidos/listaPedidos':
        $pedidosController->listaPedidos();
        break;
    case '/pedidos/detalle':
        $pedidosController->detallePedido();
        break;
    case '/pedidos/aceptar':
        $pedidosController->aceptarPedido();
        break;
    case '/pedidos/denegar':
        $pedidosController->denegarPedido();
        break;
    case '/pedidos/editarPedido':
        $pedidosController->editarPedido();
        break;
    case '/pedidos/devolver':
        $pedidosController->devolverPedido();
        break;
    case '/proveedores/index':
        $proveedoresController->index();
        break;
    case '/proveedores/agregar':
        $proveedoresController->agregar();
        break;
    case '/proveedores/agregarProveedor':
        $proveedoresController->agregarProveedor();
        break;
    case '/proveedores/actualizar':
        $proveedoresController->actualizarUsuario();
        break;
    case '/proveedores/obtenerProveedorPorId':
        $proveedoresController->obtenerProveedorPorId();
        break;
    case '/salidas/index':
        $salidasControlador->index();
        break;
    case '/salidas/obtenerSalidaPorId':
        $salidasControlador->obtenerSalidaPorID();
        break;
    case '/registros/totalRegistros':
        $registrosControlador->totalRegistros();
        break;
    case '/registros/totalCapital':
        $registrosControlador->totalCapital();
        break;
    case '/registros/totalPorCategoria':
        $registrosControlador->totalPorCategoria();
        break;
    case '/registros/index':
        $registrosControlador->index();
        break;
    case '/error403':
        require_once __DIR__ . '/Web/vistas/error403.php';
        break;
    case '/error404':
        require_once __DIR__ . '/Web/vistas/error404.php';
        break;
    case '/error501':
        require_once __DIR__ . '/Web/vistas/error501.php';
        break;


    default:
        http_response_code(404);
        break;
}

include __DIR__ . '/Web/components/Footer.php';

ob_end_flush();
