<?php
require_once __DIR__ . '/../BL/Entradas/EntradaBL.php';
require_once __DIR__ . '/../BL/Usuario/UsuarioBL.php';
require_once __DIR__ . '/../BL/Bitacora/BitacoraBL.php';
require_once __DIR__ . '/../BL/Inventario/InventarioBL.php';


require_once __DIR__ . '/Controller.php';

use BL\Entradas\EntradaBL;
use BL\Usuario\UsuarioBL;
use BL\Bitacora\BitacoraBL;
use BL\Inventario\InventarioBL;


class EntradaControlador extends Controller
{
    private EntradaBL $entradaBL;
    private UsuarioBL $usuarioBL;
    private BitacoraBL $bitacoraBL;
    private InventarioBL $inventarioBL;



    public function __construct($conn)
    {
        $this->entradaBL = new EntradaBL($conn);
        $this->usuarioBL = new UsuarioBL($conn);
        $this->bitacoraBL = new BitacoraBL($conn);
        $this->inventarioBL = new InventarioBL($conn);
    }

    public function agregarArticulo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria = !empty($_POST['categoria']) ? $_POST['categoria'] : null;

            if (filter_var($_POST['adquisicionAgregada'], FILTER_VALIDATE_BOOLEAN)) {
                $adquisicion = [
                    'fecha_adquisicion' => !empty($_POST['fecha_adquisicion']) ? $_POST['fecha_adquisicion'] : null,
                    'persona_compra' => !empty($_POST['persona_compra']) ? $_POST['persona_compra'] : null,
                    'proveedor' => !empty($_POST['proveedor']) ? $_POST['proveedor'] : null,
                    'numero_factura' => !empty($_POST['factura']) ? $_POST['factura'] : null,
                    'numero_fondo' => !empty($_POST['numero_fondo']) ? $_POST['numero_fondo'] : null,
                    'tipo_pago' => !empty($_POST['tipo_pago']) ? $_POST['tipo_pago'] : null,
                    'garantia' => !empty($_POST['garantia']) ? $_POST['garantia'] : null,
                    'cantidad' => !empty($_POST['cantidad']) ? $_POST['cantidad'] : null
                ];

                if ($_POST['persona_compra'] == "otros") {
                    $adquisicion['persona_compra'] = $_POST['otra_persona'];
                };

                if (isset($_POST['fecha_entrada'])) {
                    $adquisicion['fecha_entrada'] = $_POST['fecha_entrada'];
                }
            } else {
                $adquisicion = [
                    'persona_compra' => $_SESSION['usuario_INMASY']['nombre_completo'],
                    'cantidad' => !empty($_POST['cantidad']) ? $_POST['cantidad'] : null

                ];
            }
            if (!empty($_POST['id_articulo'])) {
                $articuloNuevo = ['id_articulo' => $_POST['id_articulo'], 'cantidad' => $_POST['cantidad']];
                $almacenamiento = ['tipo' => 'Inventario'];
            } else {
                $articuloNuevo = [
                    'nombre' => !empty($_POST['nombre']) ? $_POST['nombre'] : null,
                    'marca' => !empty($_POST['marca']) ? $_POST['marca'] : null,
                    'modelo' => !empty($_POST['modelo']) ? $_POST['modelo'] : null,
                    'serial' => !empty($_POST['serial']) ? $_POST['serial'] : null,
                    'costo_unitario' => !empty($_POST['costo_unitario']) ? $_POST['costo_unitario'] : null,
                    'estado' => !empty($_POST['estado']) ? $_POST['estado'] : null,
                    'direccion' => !empty($_POST['direccion']) ? $_POST['direccion'] : null,
                    'cantidad' => !empty($_POST['cantidad']) ? $_POST['cantidad'] : null,
                    'activo' => 1,
                    'fecha_fabricacion' => !empty($_POST['fecha_fabricacion']) ? $_POST['fecha_fabricacion'] : null,
                    'disponibilidad' => 0,
                    'num_articulo' => !empty($_POST['num_articulo']) ? $_POST['num_articulo'] : null,
                ];
                if (isset($_POST['tipoElectronica'])) {
                    $articuloNuevo['atributos'] = json_encode(['tipo' => $_POST['tipoElectronica']]);
                };
                if (isset($_POST['vac'])) {
                    $articuloNuevo['atributos'] = json_encode(['vac' => $_POST['vac'], 'aidi' => $_POST['aidi'], 'vdc' => $_POST['vdc'], 'tipo' => $_POST['tipo'], 'phase' => $_POST['phase'], 'ground' => $_POST['ground']]);
                }
                if (isset($_POST['tipoTarjeta'])) {
                    if (isset($_POST['otro_tipo'])) {
                        $tipo = $_POST['otro_tipo'];
                        $articuloNuevo['atributos'] = json_encode(['tipo' => $tipo]);
                    } else {
                        $articuloNuevo['atributos'] = json_encode(['tipo' => $_POST['tipoTarjeta']]);
                    }
                }
                if (isset($_POST['peso'])) {
                    $articuloNuevo['atributos'] = json_encode(['peso' => $_POST['peso']]);
                };
                if (isset($_POST['puertos'])) {
                    $articuloNuevo['atributos'] = json_encode(['puertos' => $_POST['puertos'], 'tipo' => $_POST['tipo']]);
                };
                if (isset($_POST['descripcion1'])) {
                    $articuloNuevo['atributos'] = json_encode(['descripcion1' => $_POST['descripcion1'], 'descripcion2' => $_POST['descripcion2']]);
                };
                if (isset($_POST['corriente'])) {
                    $articuloNuevo['atributos'] = json_encode(['corriente' => $_POST['corriente'], 'numero' => $_POST['numero']]);
                };
                if (isset($_POST['montaje'])) {
                    $articuloNuevo['atributos'] = json_encode([
                        'corriente_nominal' => $_POST['corrienteNominal'],
                        'tension_nominal' => $_POST['tension'],
                        'control' => $_POST['control'],
                        'montaje' => $_POST['montaje'],
                        'protocolo' => (isset($_POST['protocolo'])) ? $_POST['protocolo'] : $_POST['otro_protocolo'],
                        'aidi' => $_POST['aidi']
                    ]);
                }
                if (isset($_POST['instalacion'])) {
                    $articuloNuevo['atributos'] = json_encode([
                        'corriente_nominal' => $_POST['corrienteNominal'],
                        'tension_nominal' => $_POST['tension'],
                        'operacion' => $_POST['operacion'],
                        'corte' => $_POST['corte'],
                        'instalacion' => $_POST['instalacion'],
                        'aidi' => $_POST['aidi']
                    ]);
                }
                if (isset($_POST['medida'])) {
                    $articuloNuevo['atributos'] = json_encode(['medida' => $_POST['medida'], 'numero' => $_POST['numero'], 'caja' => $_POST['caja']]);
                };

                $almacenamiento = ['tipo' => $_POST['almacenamiento']];

                if ($_POST['almacenamiento'] == 'bodega') {
                    $almacenamiento['num_catalogo'] = $_POST['num_catalogo'];
                }
            }

            $resultado = $this->entradaBL->agregarArticulo($articuloNuevo, $adquisicion, $categoria, $almacenamiento);

            if (isset($resultado['error'])) {
                $this->bitacoraBL->registrarBitacora([
                    'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                    'categoria' => 'ENTRADAS',
                    'fecha' => $this->registrarFechaHora(),
                    'descripcion' => "Agregar entrante error: {$resultado['error']}",
                    'accion' => 'INSERT',
                    'estado' => 'ERROR'
                ]);
                $this->view('/Vistas/error501', ['mensaje' => $resultado['error']]);

                return;
            }

            $this->bitacoraBL->registrarBitacora([
                'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                'categoria' => 'ENTRADAS',
                'fecha' => $this->registrarFechaHora(),
                'descripcion' => "Agregar Entrante ID: {$resultado['id']}",
                'accion' => 'INSERT',
                'estado' => 'SUCCESS'
            ]);

            $this->redirect('/entrada/index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $categoria = $_GET['categoria'] ?? null;
            $usuarios = $this->usuarioBL->obtenerUsuariosPADDE();
            $categorias = $this->entradaBL->obtenerCategorias();
            $proveedores = $this->entradaBL->obtenerProveedores();
            $this->view('entrada/agregar', ['categorias' => $categorias, 'proveedores' => $proveedores, 'usuarios' => $usuarios, 'categoriaSeleccionada' => $categoria]);
        }
    }

    public function reponerStock()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria = $_POST['categoria'];
            $articulos = $this->inventarioBL->obtenerArticulosPorCategoria($categoria);

            $this->json(['success' => true, 'data' => $articulos]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $usuarios = $this->usuarioBL->obtenerUsuariosPADDE();
            $categorias = $this->entradaBL->obtenerCategorias();
            $proveedores = $this->entradaBL->obtenerProveedores();
            $this->view('entrada/reponer', ['categorias' => $categorias, 'proveedores' => $proveedores, 'usuarios' => $usuarios]);
        }
    }

    public function editarEntrada()
    {
        $entrada = [
            'tipo_pago' => !empty($_POST['tipo_pago']) ?: null,
            'numero_fondo' =>  !empty($_POST['numero_fondo']) ?: null,
            'numero_factura' => !empty($_POST['factura']) ?: null,
            'fecha_adquisicion' => !empty( $_POST['fecha_adquisicion'])? $_POST['fecha_adquisicion'] : null,

            'garantia' =>  !empty($_POST['garantia']) ?: null,
            'proveedor' => !empty( $_POST['proveedor'])? $_POST['proveedor'] : null,
            'id_entrada' => $_POST['id_entrante'],
        ];

        if (!empty($_POST['persona_compra'])) {
            if ($_POST['persona_compra'] == "otros") {
                $entrada['persona_compra'] = $_POST['otra_persona'];
            } else {
                $entrada['persona_compra'] = $_POST['persona_compra'];
            };
        } else {
            $entrada['persona_compra'] = $_SESSION['usuario_INMASY']['nombre_completo'];
        }
        $resultado = $this->entradaBL->editarEntrada($entrada);

        if (isset($resultado['error'])) {
            $this->bitacoraBL->registrarBitacora([
                'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
                'categoria' => 'ENTRADAS',
                'fecha' => $this->registrarFechaHora(),
                'descripcion' => "Editar entrante error: {$resultado['error']}",
                'accion' => 'UPDATE',
                'estado' => 'ERROR'
            ]);
            $this->view('/Vistas/error403', ['error' => $resultado['error']]);
        }

        $this->bitacoraBL->registrarBitacora([
            'id_usuario' => $_SESSION['usuario_INMASY']['ID_Usuario'],
            'categoria' => 'ENTRADAS',
            'fecha' => $this->registrarFechaHora(),
            'descripcion' => "Editar Entrante ID: {$resultado['id']}",
            'accion' => 'UPDATE',
            'estado' => 'SUCCESS'
        ]);
        $this->json($resultado);
    }

    public function obtenerEntradaPorId()
    {


        $id = $_GET['id'];
        $entrada = $this->entradaBL->obtenerEntradaPorId($id);

        $this->json(['success' => true, 'data' => $entrada]);
    }

    public function obtenerEntradas()
    {
        $usuarios = $this->usuarioBL->obtenerUsuariosPADDE();
        $proveedores = $this->entradaBL->obtenerProveedores();
        $entradas = $this->entradaBL->obtenerEntradas();
        $this->view('entrada/index', ['entradas' => $entradas, 'proveedores' => $proveedores, 'usuarios' => $usuarios]);
    }

    public function establecerFecha()
    {
        $id = $_GET['id'];
        $resultado = $this->entradaBL->establecerFecha($id);
        $this->json($resultado);
    }

    private function registrarFechaHora()
    {
        $zona = new DateTimeZone('America/Costa_Rica');
        $fechaConZona = new DateTime('now', $zona);
        return $fechaConZona->format('Y-m-d H:i:s');
    }
}
