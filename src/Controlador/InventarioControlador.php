<?php
require_once __DIR__ . '/Controller.php';
require_once dirname(__DIR__, 2) . "/src/BL/Inventario/InventarioBL.php";
require_once __DIR__ . '/../BL/Bitacora/BitacoraBL.php';

use BL\Inventario\InventarioBL;
use BL\Bitacora\BitacoraBL;


class InventarioControlador extends Controller
{
    private InventarioBL $inventarioBL;
    private BitacoraBL $bitacoraBL;

    public function __construct($conn)
    {
        $this->inventarioBL = new InventarioBL($conn);
        $this->bitacoraBL = new BitacoraBL($conn);
    }

    public function obtenerArticulosPorCategoria($id, $categoria)
    {
        $articulos = $this->inventarioBL->obtenerArticulosPorCategoria($id);
        $this->view('inventario/' . $categoria, ['articulos' => $articulos]);
    }

    public function obtenerArticuloPorId()
    {
        $id = $_GET['id'];
        $categoria = $_GET['categoria'];
        $articulo = $this->inventarioBL->obtenerArticuloPorId($categoria, $id);


        $this->json(['success' => true, 'data' => $articulo]);
    }
    public function editarArticulo()
    {
        $categoria = $_POST['categoria'];
        $articuloActualizado = [
            'nombre' => $_POST['nombre'],
            'marca' => $_POST['marca'],
            'modelo' => $_POST['modelo'],
            'serial' => $_POST['serial'],
            'costo_unitario' => $_POST['costo_unitario'],
            'estado' => $_POST['estado'],
            'direccion' => isset($_POST['direccion']) ? $_POST['direccion'] : null,
            'cantidad' => $_POST['cantidad'],
            'activo' => $_POST['activo'],
            'disponibilidad' => 0,
            'ID_Articulo' => $_POST['ID_Articulo'],
            'num_articulo' => $_POST['num_articulo']

        ];
        if (isset($_POST['tipoElectronica'])) {
            $articuloActualizado['atributos'] = json_encode(['tipo' => $_POST['tipoElectronica']]);
        };
        if (isset($_POST['vac'])) {
            $articuloActualizado['atributos'] = json_encode(['vac' => $_POST['vac'], 'aidi' => $_POST['aidi'], 'vdc' => $_POST['vdc'], 'tipo' => $_POST['tipo'], 'ground' => $_POST['ground'], 'phase' => $_POST['phase'], 'num_catalogo' => $_POST['num_catalogo']]);
        }
        if (isset($_POST['peso'])) {
            $articuloActualizado['atributos'] = json_encode(['peso' => $_POST['peso']]);
        };
        if (isset($_POST['puertos'])) {
            $articuloActualizado['atributos'] = json_encode(['puertos' => $_POST['puertos'], 'tipo' => $_POST['tipo']]);
        };
        if (isset($_POST['descripcion1'])) {
            $articuloActualizado['atributos'] = json_encode(['descripcion1' => $_POST['descripcion1'], 'descripcion2' => $_POST['descripcion2']]);
        };
        if (isset($_POST['corriente'])) {
            $articuloActualizado['atributos'] = json_encode(['corriente' => $_POST['corriente'], 'numero' => $_POST['numero']]);
        };
        if (isset($_POST['montaje'])) {

            if (!empty($_POST['otro_protocolo'])) {
                $articuloActualizado['atributos'] = json_encode([
                    'protocolo' => $_POST['otro_protocolo'],
                    'corriente_nominal' => $_POST['corriente_nominal'],
                    'tension_nominal' => $_POST['tension_nominal'],
                    'control' => $_POST['control'],
                    'montaje' => $_POST['montaje'],
                ]);
            } else {
                $articuloActualizado['atributos'] = json_encode([
                    'protocolo' => $_POST['protocolo'],
                    'corriente_nominal' => $_POST['corriente_nominal'],
                    'tension_nominal' => $_POST['tension_nominal'],
                    'control' => $_POST['control'],
                    'montaje' => $_POST['montaje'],
                ]);
            }
        }
        if (isset($_POST['instalacion'])) {
            $articuloActualizado['atributos'] = json_encode([
                'corriente_nominal' => $_POST['corriente_nominal'],
                'tension_nominal' => $_POST['tension_nominal'],
                'operacion' => $_POST['operacion'],
                'corte' => $_POST['corte'],
                'instalacion' => $_POST['instalacion']
            ]);
        }
        if (isset($_POST['medida'])) {
            $articuloActualizado['atributos'] = json_encode([
                'medida' => $_POST['medida'],
                'numero' => $_POST['numero'],
                'caja' => $_POST['caja'],

            ]);
        }
        if (isset($_POST['tipoTarjeta'])) {
            if (isset($_POST['otro_tipo'])) {
                $tipo = $_POST['otro_tipo'];
                $articuloActualizado['atributos'] = json_encode(['tipo' => $tipo]);
            } else {
                $articuloActualizado['atributos'] = json_encode(['tipo' => $_POST['tipoTarjeta']]);
            }
        }

        $resultado = $this->inventarioBL->editarArticulo($articuloActualizado);
        if (isset($resultado['error'])) {
            $this->bitacoraBL->registrarBitacora([
                'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                'categoria' => 'INVENTARIO',
                'fecha' => $this->registrarFechaHora(),
                'descripcion' => "editar articulo error: {$resultado['error']}",
                'accion' => 'UPDATE',
                'estado' => 'ERROR'
            ]);
            $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);

            return;
        }

        $this->bitacoraBL->registrarBitacora([
            'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
            'categoria' => 'INVENTARIO',
            'fecha' => $this->registrarFechaHora(),
            'descripcion' => "Editar articulo ID: {$resultado['id']}",
            'accion' => 'UPDATE',
            'estado' => 'SUCCESS'
        ]);
        $this->redirect('/inventario/categoria?categoria=' . $categoria . '&id=' . $resultado['categoria']);
    }

    public function sacarArticulo()
    {
        $entrada = $_POST['id'];
        $motivo = $_POST['descripcion'];

        $resultado = $this->inventarioBL->sacarArticulo($entrada,  $motivo);

        if (isset($resultado['error'])) {
            $this->bitacoraBL->registrarBitacora([
                'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                'categoria' => 'INVENTARIO',
                'fecha' => $this->registrarFechaHora(),
                'descripcion' => "Sacar articulo error: {$resultado['error']}",
                'accion' => 'DELETE',
                'estado' => 'ERROR'
            ]);
            $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);

            return;
        }

        $this->bitacoraBL->registrarBitacora([
            'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
            'categoria' => 'INVENTARIO',
            'fecha' => $this->registrarFechaHora(),
            'descripcion' => "Sacar articulo ID: {$resultado['id']}",
            'accion' => 'DELETE',
            'estado' => 'SUCCESS'
        ]);
        $this->json($resultado);
    }
    public function pedirArticulo()
    {
        $pedido = [
            'fecha' => $_POST['fecha'],
            'num_orden' => null,
            'id_articulo' => $_POST['id_articulo'],
            'nombre_cliente' => $_POST['nombre_cliente'],
            'estado' => 'PENDIENTE',
            'usuario' => $_SESSION['usuario_INMASY']['nombre_completo'],
            'id_cliente' => $_SESSION['usuario_INMASY']['ID_Usuario']

        ];

        if (isset($_POST['direccion'])) {
            $pedido['direccion'] = $_POST['direccion'];
        } else {
            $pedido['cantidad'] = $_POST['cantidad'];
        }

        $resultado = $this->inventarioBL->pedirArticulo($pedido);
        if (isset($resultado['error'])) {
            $this->bitacoraBL->registrarBitacora([
                'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                'categoria' => 'PEDIDOS',
                'fecha' => $this->registrarFechaHora(),
                'descripcion' => "Inserta pedido error: {$resultado['error']}",
                'accion' => 'INSERT',
                'estado' => 'ERROR'
            ]);
            $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);

            return;
        }

        $this->bitacoraBL->registrarBitacora([
            'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
            'categoria' => 'PEDIDOS',
            'fecha' => $this->registrarFechaHora(),
            'descripcion' => "Insertar pedido ID: {$resultado['id']}",
            'accion' => 'INSERT',
            'estado' => 'SUCCESS'
        ]);


        $this->json($resultado);
    }
    private function registrarFechaHora()
    {
        $zona = new DateTimeZone('America/Costa_Rica');
        $fechaConZona = new DateTime('now', $zona);
        return $fechaConZona->format('Y-m-d H:i:s');
    }
}
