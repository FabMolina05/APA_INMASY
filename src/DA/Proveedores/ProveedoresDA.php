<?php

namespace DA\Proveedores;

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/DA/IProveedoresDA.php";

use ABS\Interfaces\DA\IProveedoresDA;
use DA\Context\DBContext;

class ProveedoresDA implements IProveedoresDA
{
    private $conexion;

    public function __construct($conn)
    {

        $this->conexion = $conn;
    }

    public function obtenerProveedorPorId($id)
    {
        $query = "SELECT * FROM dbo.INMASY_Proveedores WHERE ID_Proveedor = ?";
        $params = [$id];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }

        $proveedor = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $proveedor;
    }




    public function obtenerProveedores()
    {
        $query = "SELECT ID_Proveedor, nombre, direccion, telefono, correo FROM dbo.INMASY_Proveedores ORDER BY ID_Proveedor DESC";
        $stmt = sqlsrv_prepare($this->conexion, $query);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $proveedores = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $proveedores[] = $row;
        }
        return $proveedores;
    }

    public function agregarProveedor($proveedor)
    {
        $query = "INSERT INTO dbo.INMASY_Proveedores (nombre, direccion, telefono, correo) VALUES (?, ?, ?, ?)";
        $params = [
            $proveedor['nombre'],
            $proveedor['direccion'],
            $proveedor['telefono'],
            $proveedor['correo']
        ];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        return ['success' => true];
    }

    public function actualizarProveedor($proveedor)
    {
        $query = "UPDATE dbo.INMASY_Proveedores SET nombre = ?, direccion = ?, telefono = ?, correo = ? WHERE ID_Proveedor = ?";
        $params = [
            $proveedor['nombre'],
            $proveedor['direccion'],
            $proveedor['telefono'],
            $proveedor['correo'],
            $proveedor['id']
        ];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        return ['success' => true];
    }
}
