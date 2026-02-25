<?php

namespace BL\Proveedores;

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/BL/IProveedoresBL.php";
require_once dirname(__DIR__, 3) . "/src/DA/Proveedores/ProveedoresDA.php";

use ABS\Interfaces\BL\IProveedoresBL;
use DA\Proveedores\ProveedoresDA;
use Exception;

class ProveedoresBL implements IProveedoresBL
{
    private $proveedoresDA;

    public function __construct($conn)
    {
        $this->proveedoresDA = new ProveedoresDA($conn);
    }

    public function agregarProveedor($proveedor)
    {
        try {
            $resultado = $this->proveedoresDA->agregarProveedor($proveedor);

            return $resultado;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actualizarProveedor($proveedor)
    {
        try {
            $resultado = $this->proveedoresDA->actualizarProveedor($proveedor);

            return $resultado;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function obtenerProveedores()
    {
        try {
            $proveedores = $this->proveedoresDA->obtenerProveedores();

            return $proveedores;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function obtenerProveedorPorId($id)
    {
        try {
            $proveedor = $this->proveedoresDA->obtenerProveedorPorId($id);

            return $proveedor;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function desactivarProveedor($id) {
        try {
            $resultado = $this->proveedoresDA->desactivarProveedor($id);

            return $resultado;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
