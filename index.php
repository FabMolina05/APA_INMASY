<?php 
require_once __DIR__ . '/src/DA/DBContext.php';
require_once __DIR__ . '/src/Controlador/IndexControlador.php';
require_once __DIR__ . '/src/Controlador/UsuarioControlador.php';
require_once __DIR__ . '/src/Services/validate_session.php';
require_once __DIR__ . '/src/Services/validate_permission.php';
include __DIR__ . '/Web/components/Header.php';

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

ValidateSession::validate($conn);
ValidatePermissions::validate($request);

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
    case '/inventario/comunicaciones':
        $indexController->index();
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


?>

<?php include __DIR__ . '/Web/components/Footer.php'; ?>