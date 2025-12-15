<?php 
require_once __DIR__ . '/src/DA/DBContext.php';
require_once __DIR__ . '/src/Controlador/IndexControlador.php';
require_once __DIR__ . '/src/Controlador/UsuarioControlador.php';
include __DIR__ . '/Web/components/Header.php';
include __DIR__ . '/Web/components/Sidebar.php';
use DA\DBContext;
?>
<?php

$dbContext = new DBContext();
$conn = $dbContext->getConnection();
$indexController = new IndexControlador();
$usuarioController = new UsuarioControlador($conn);

$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');
$request = str_replace('/index.php', '', $request);
$request = $request ?: '/';

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

    default:
        http_response_code(404);
        break;
};


?>

<?php include __DIR__ . '/Web/components/Footer.php'; ?>