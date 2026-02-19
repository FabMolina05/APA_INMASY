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

        sqlsrv_free_stmt($stmt);

        $query = "SELECT ID_Contacto as id, nombre_contacto as nombre,correo as correo FROM dbo.INMASY_proveedor_contactos WHERE id_proveedor = ?";
        $params = [$id];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }

        $contactos = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $contactos[] = $row;
        }
        sqlsrv_free_stmt($stmt);
        return ['contactos' => $contactos, 'proveedor' => $proveedor];
    }




    public function obtenerProveedores()
    {
        $query = "SELECT ID_Proveedor, nombre, direccion, telefono,activo FROM dbo.INMASY_Proveedores ORDER BY ID_Proveedor DESC";
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
        $query = "INSERT INTO dbo.INMASY_Proveedores (nombre, direccion, telefono,direccion_url,activo) VALUES (?, ?, ?,?,?);
        SELECT SCOPE_IDENTITY() AS id;";
        $params = [
            $proveedor['nombre'],
            $proveedor['direccion'],
            $proveedor['telefono'],
            $proveedor['url'],
            1
        ];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }

        $id = $this->obtenerSiguienteId($stmt);

        if (isset($proveedor['correos']) && is_array($proveedor['correos'])) {
            $query = "INSERT INTO dbo.INMASY_proveedor_contactos (id_proveedor, nombre_contacto, correo) VALUES (?, ?, ?)";

            foreach ($proveedor['correos'] as $index => $correo) {
                if (!empty($correo['correo'])) {
                    $params = [
                        $id,
                        $correo['nombre'] ?? null,
                        $correo['correo']
                    ];

                    $stmt = sqlsrv_prepare($this->conexion, $query, $params);

                    if (!sqlsrv_execute($stmt)) {
                        $errors = sqlsrv_errors();
                        return ['error' => $errors[0]['message']];
                    }
                }
            }
        }

        sqlsrv_commit($this->conexion);

        return ['success' => true, 'id' => $id];
    }

    public function actualizarProveedor($proveedor)
    {
        $query = "UPDATE dbo.INMASY_Proveedores SET nombre = ?, direccion = ?, telefono = ?,direccion_url = ?, activo = ? WHERE ID_Proveedor = ?";
        $params = [
            $proveedor['nombre'],
            $proveedor['direccion'],
            $proveedor['telefono'],
            $proveedor['url'],
            $proveedor['activo'],
            $proveedor['id']
        ];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);

            return ['error' => $errors[0]['message']];
        }
        if (isset($proveedor['correosNuevos']) && is_array($proveedor['correosNuevos'])) {
            $query = "INSERT INTO dbo.INMASY_proveedor_contactos (id_proveedor, nombre_contacto, correo) VALUES (?, ?, ?)";

            foreach ($proveedor['correosNuevos'] as $index => $correo) {
                if (!empty($correo['correo'])) {
                    $params = [
                        $proveedor['id'],
                        $correo['nombre'] ?? null,
                        $correo['correo']
                    ];

                    $stmt = sqlsrv_prepare($this->conexion, $query, $params);

                    if (!sqlsrv_execute($stmt)) {
                        $errors = sqlsrv_errors();
                        sqlsrv_rollback($this->conexion);

                        return ['error' => $errors[0]['message']];
                    }
                }
            }
        }

        $query = "UPDATE dbo.INMASY_proveedor_contactos SET nombre_contacto = ?, correo = ? WHERE id_contacto = ?";
        foreach ($proveedor['correosExiste'] as $index => $correo) {
            if (!empty($correo['correo'])) {
                $params = [

                    $correo['nombre'] ?? null,
                    $correo['correo'],
                    $correo['id']
                ];

                $stmt = sqlsrv_prepare($this->conexion, $query, $params);

                if (!sqlsrv_execute($stmt)) {
                    $errors = sqlsrv_errors();
                    sqlsrv_rollback($this->conexion);
                    return ['error' => $errors[0]['message']];
                }
            }
        }

        sqlsrv_commit($this->conexion);
        return ['success' => true];
    }

    public function desactivarProveedor($id)
    {
        $query = "UPDATE dbo.INMASY_Proveedores SET activo = ? WHERE ID_Proveedor = ?";
        $params = [
            0,
            $id
        ];
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);

            return ['error' => $errors[0]['message']];
        }

        sqlsrv_commit($this->conexion);

        return ['success' => true];
    }
    private function obtenerSiguienteId($stmt)
    {
        sqlsrv_next_result($stmt);
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($stmt);

        if (!isset($row['id']) || $row['id'] === null) {
            throw new \Exception("SCOPE_IDENTITY retornó NULL");
        }

        return (int)$row['id'];
    }
}
