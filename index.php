<?php include __DIR__ .'/Web/components/Header.php'; ?>
<?php include __DIR__ .'/Web/components/Sidebar.php'; ?>
<?php require_once __DIR__ . '/src/Controlador/IndexControlador.php'; ?>
<?php
$indexController = new IndexControlador();

$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');
$request = str_replace('/index.php', '', $request);
$request = $request ?: '/';

switch ($request) {
    case '/' : 
     $indexController->index();
     break;
    default :
     http_response_code(404);
     break;
};


?>

<?php include __DIR__ . '/Web/components/Footer.php'; ?>