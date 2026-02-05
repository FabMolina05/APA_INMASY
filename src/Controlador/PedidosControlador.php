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

    public function listaPedidos()
    {
        $PedidosGenerales = $this->PedidosBL->obtenerPedidos();
        $this->json( ['data' => $PedidosGenerales]);
    }

    public function denegarPedido()
    {
         $pedido = [
            'id' => $_POST['id'],
            'descripcion' => $_POST['descripcion'],
            'encargado'=> $_SESSION['usuario_INMASY']['ID_Usuario']
        ];
        $resultado = $this->PedidosBL->denegarPedido($pedido);

        $this->json($resultado);
    }
    public function aceptarPedido()
    {

        $pedido = [
            'id' => $_POST['id'],
            'encargado' => $_POST['encargado'],
            'num_orden' => !empty($_POST['num_orden'])?$_POST['num_orden']: null,
        ];

        $resultado = $this->PedidosBL->aceptarPedido($pedido);

        $this->json($resultado);
    }
    public function detallePedido()
    {

        $id = $_GET['id'];
        $pedido = $this->PedidosBL->detallePedido($id);
        $this->json(['success' => true, 'data' => $pedido]);
    }

    public function editarPedido()
    {
        $pedido = [
            'direccion' => !empty($_POST['direccion'])?$_POST['direccion'] : null,
            'cantidad'=> !empty($_POST['cantidad'])?$_POST['cantidad']: null,
            'fecha' => $_POST['fecha'],
            'id_pedido' => $_POST['id_pedido'],
            
        ];

        $resultado = $this->PedidosBL->editarPedido($pedido);

        
        $this->json($resultado);
    }

    public function devolverPedido(){
        $pedido = $_POST['id'];
        $resultado = $this->PedidosBL->devolverPedido($pedido);
        $this->json($resultado);

    }
}
