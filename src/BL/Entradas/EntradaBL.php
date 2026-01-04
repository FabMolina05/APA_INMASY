<?php
namespace BL\Entradas;

require_once __DIR__ . '/../../ABS/Interfaces/BL/IEntradaBL.php';
require_once __DIR__ . '/../../DA/Entradas/EntradaDA.php';

use ABS\Interfaces\BL\IEntradaBL;
use DA\Entradas\EntradaDA;
use Exception;

class EntradaBL implements IEntradaBL
{
    private $entradaDA;

    public function __construct($conn)
    {
        $this->entradaDA = new EntradaDA($conn);
    }

    public function agregarArticulo($articulo, $adquisicion, $categoria)
    {
        try {
            $resultado = $this->entradaDA->agregarArticulo($articulo, $adquisicion, $categoria);

            return $resultado;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function editarEntrada($entrada)
    {
        try {
            $resultado = $this->entradaDA->editarEntrada($entrada);

            return $resultado;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function obtenerEntradas()
    {
        try {
            $entradas = $this->entradaDA->obtenerEntradas();

            return $entradas;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function obtenerCategorias()
    {
        try {
            $categorias = $this->entradaDA->obtenerCategorias();

            return $categorias;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function obtenerProveedores()
    {
        try {
            $proveedores = $this->entradaDA->obtenerProveedores();

            return $proveedores;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
