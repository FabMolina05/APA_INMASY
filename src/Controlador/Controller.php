<?php

class Controller {
    
    protected function view($viewPath, $data = []) {
        extract($data);
        
        $viewFile = dirname(__DIR__, 2) . "/Web/" . $viewPath . ".php";
        
        if (!file_exists($viewFile)) {

            die("Vista no encontrada: $viewFile");
        }
        
        require_once $viewFile;
    }
    
    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
    
    protected function json($data, $statusCode = 200) {
        if (ob_get_level()) ob_clean();
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
}