<?php

require_once dirname(__DIR__, 2) . "/src/BL/Pedidos/PedidosBL.php";
require_once dirname(__DIR__, 2) . "/src/BL/Bitacora/BitacoraBL.php";


use BL\Pedidos\PedidosBL;
use BL\Bitacora\BitacoraBL;

class PedidosControlador extends Controller
{
    private PedidosBL $PedidosBL;
    private BitacoraBL $bitacoraBL;

    public function __construct($conn)
    {
        $this->PedidosBL = new PedidosBL($conn);
        $this->bitacoraBL = new BitacoraBL($conn);
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
        $this->json(['data' => $PedidosGenerales]);
    }

    public function denegarPedido()
    {
        $pedido = [
            'id' => $_POST['id'],
            'descripcion' => $_POST['descripcion'],
            'encargado' => $_SESSION['usuario_INMASY']['ID_Usuario']
        ];
        $resultado = $this->PedidosBL->denegarPedido($pedido);
        if (isset($resultado['error'])) {
            $this->bitacoraBL->registrarBitacora([
                'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                'categoria' => 'PEDIDOS',
                'fecha' => $this->registrarFechaHora(),
                'descripcion' => "Denegar pedido error: {$resultado['error']}",
                'accion' => 'UPDATE',
                'estado' => 'ERROR'
            ]);
            $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);

            return;
        }

        $this->bitacoraBL->registrarBitacora([
            'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
            'categoria' => 'PEDIDOS',
            'fecha' => $this->registrarFechaHora(),
            'descripcion' => "Denegar pedido ID: {$resultado['id']}",
            'accion' => 'UPDATE',
            'estado' => 'SUCCESS'
        ]);

        $this->json($resultado);
    }
    public function aceptarPedido()
    {

        $pedido = [
            'id' => $_POST['id'],
            'encargado' => $_POST['encargado'],
            'num_orden' => !empty($_POST['num_orden']) ? $_POST['num_orden'] : null,
        ];

        $resultado = $this->PedidosBL->aceptarPedido($pedido);

        if (isset($resultado['error'])) {
            $this->bitacoraBL->registrarBitacora([
                'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                'categoria' => 'PEDIDOS',
                'fecha' => $this->registrarFechaHora(),
                'descripcion' => "Aceptar pedido error: {$resultado['error']}",
                'accion' => 'UPDATE',
                'estado' => 'ERROR'
            ]);;
            $this->json($resultado);
            return;
        }

        $this->bitacoraBL->registrarBitacora([
            'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
            'categoria' => 'PEDIDOS',
            'fecha' => $this->registrarFechaHora(),
            'descripcion' => "Aceptar pedido ID: {$resultado['id']}",
            'accion' => 'UPDATE',
            'estado' => 'SUCCESS'
        ]);

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
            'direccion' => !empty($_POST['direccion']) ? $_POST['direccion'] : null,
            'cantidad' => !empty($_POST['cantidad']) ? $_POST['cantidad'] : null,
            'fecha' => $_POST['fecha'],
            'id_pedido' => $_POST['id_pedido'],

        ];

        $resultado = $this->PedidosBL->editarPedido($pedido);
        if (isset($resultado['error'])) {
            $this->bitacoraBL->registrarBitacora([
                'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                'categoria' => 'PEDIDOS',
                'fecha' => $this->registrarFechaHora(),
                'descripcion' => "Editar pedido error: {$resultado['error']}",
                'accion' => 'UPDATE',
                'estado' => 'ERROR'
            ]);
            $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);

            return;
        }

        $this->bitacoraBL->registrarBitacora([
            'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
            'categoria' => 'PEDIDOS',
            'fecha' => $this->registrarFechaHora(),
            'descripcion' => "Editar pedido ID: {$resultado['id']}",
            'accion' => 'UPDATE',
            'estado' => 'SUCCESS'
        ]);

        $this->json($resultado);
    }

    public function devolverPedido()
    {
        $pedido = $_POST['id'];
        $resultado = $this->PedidosBL->devolverPedido($pedido);
        $this->json($resultado);
    }

    private function registrarFechaHora()
    {
        $zona = new DateTimeZone('America/Costa_Rica');
        $fechaConZona = new DateTime('now', $zona);
        return $fechaConZona->format('Y-m-d H:i:s');
    }
}
