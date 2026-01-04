<?php 
require_once __DIR__ . '/src/DA/DBContext.php';

require_once __DIR__ . '/src/Controlador/IndexControlador.php';
require_once __DIR__ . '/src/Controlador/UsuarioControlador.php';
require_once __DIR__ . '/src/Controlador/InventarioControlador.php';
require_once __DIR__ . '/src/Controlador/EntradaControlador.php';

require_once __DIR__ . '/src/Services/validate_session.php';
require_once __DIR__ . '/src/Services/validate_permission.php';

use DA\DBContext;
?>
<?php

$dbContext = new DBContext();
$conn = $dbContext->getConnection();

$indexController = new IndexControlador();
$usuarioController = new UsuarioControlador($conn);
$inventarioController = new InventarioControlador($conn);
$entradaController = new EntradaControlador($conn);




$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');
$request = str_replace('/index.php', '', $request);
$request = $request ?: '/';

ValidateSession::validate($conn);
ValidatePermissions::validate($request);

ob_start();

include __DIR__ . '/Web/components/Header.php';
include __DIR__ . '/Web/components/Sidebar.php';

ob_end_flush();

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
        $inventarioController->obtenerArticulosPorCategoria($_GET['id'],$_GET['categoria']);
        break;
    
    case '/inventario/obtenerArticuloPorId':
        $inventarioController->obtenerArticuloPorId();
        break;
    case '/inventario/actualizar':
        $inventarioController->editarArticulo();
        break;
    case '/inventario/sacarArticulo':
        $inventarioController->sacarArticulo($_GET['id']);
        break;
    case '/inventario/pedirArticulo':
        $inventarioController->pedirArticulo($_GET['id']);
        break;
    case '/entrada/agregarArticulo':
        $entradaController->agregarArticulo();
        break;
    case '/error403':
        require_once __DIR__ . '/Web/vistas/error403.php';
        break;
    case '/error404':
        require_once __DIR__ . '/Web/vistas/error404.php';
        break;

    default:
        http_response_code(404);
        break;
};

include __DIR__ . '/Web/components/Footer.php'; 

?>
