<?php

require_once dirname(__DIR__, 2) . "/src/BL/Pedidos/PedidosBL.php";

use BL\Pedidos\PedidosBL;

class PedidosControlador extends Controller
{
    private PedidosBL $PedidosBL;

    public function __construct($conn)
    {
        $this->PedidosBL = new PedidosBL($conn);
    }

    public function index()
    {

        if ($_SESSION['usuario_INMASY']['rol'] == 1) {
            $PedidosGenerales = $this->PedidosBL->obtenerPedidos();
            $PedidosUsuario = $this->PedidosBL->obtenerPedidosUsuario($_SESSION['usuario_INMASY']['ID_Usuario']);
            $this->view('pedidos/index', ['pedidosGenerales' => $PedidosGenerales, 'pedidosUsuario' => $PedidosUsuario]);
        }
        $PedidosUsuario = $this->PedidosBL->obtenerPedidosUsuario($_SESSION['usuario_INMASY']['ID_Usuario']);
        $this->view('pedidos/index', ['pedidosUsuario' => $PedidosUsuario]);
    }

    public function denegarPedido()
    {
        $id = $_POST['id'];
        $resultado = $this->PedidosBL->denegarPedido($id);

        $this->json($resultado);
    }
    public function aceptarPedido()
    {

    $pedido = [
        'id' =>$_POST['id'],
        'encargado' =>$_POST['encargado'],
        'num_orden' =>$_POST['num_orden'],
    ];
        
        $resultado = $this->PedidosBL->aceptarPedido($pedido);

        $this->json($resultado);
    }
    public function detallePedido()
    {
       
        $id = $_GET['id'];
        $pedido = $this->PedidosBL->detallePedido($id);
        $this->json($pedido);
    }
}
