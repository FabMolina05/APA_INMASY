<?php

class Controller {
    
    protected function view($viewPath, $data = []) {
        extract($data);
        
        $viewFile = __DIR__ . "/../views/" . $viewPath . ".php";
        
        if (!file_exists($viewFile)) {
            die("Vista no encontrada: $viewPath");
        }
        
        require_once $viewFile;
    }
    
    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
    
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}