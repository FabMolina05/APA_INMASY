<?php

require_once __DIR__ . '/Controller.php';

class IndexControlador extends Controller {
    public function index() {
        $this->view('vistas/IndexView');
    }
}
