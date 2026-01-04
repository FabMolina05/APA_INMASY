<?php

namespace DA\Inventario;

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/DA/IInventarioDA.php";

use ABS\Interfaces\DA\IInventarioDA;

class InventarioDA implements IInventarioDA
{
    private $conexion;

    public function __construct($conn)
    {
        $this->conexion = $conn;
    }

    public function obtenerArticulosPorCategoria($categoria)
    {
        $params = array($categoria);
        $query = "SELECT a.ID_Articulo,a.id_caja,a.modelo,a.marca,a.nombre,a.disponibilidad,a.activo,JSON_VALUE(atributos_especificos,'$.tipo') as tipo
                 FROM dbo.INMASY_Articulos a
                 WHERE a.id_categoria = ?";
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $reles = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $reles[] = $row;
        }
        


        return $reles;
    }
   
    public function obtenerArticuloPorId($categoria, $id)
    {


        $query = "  SELECT a.id_caja as CAJA,a.nombre as Nombre,u.nombre_completo as Tecnico,a.modelo as Modelo,a.serial as Serial,a.estado as Estado,a.marca as  Marca,a.disponibilidad as Disponibilidad,a.direccion as Direccion,a.costo_unitario as Costo,a.cantidad as Cantidad,atributos_especificos as atributos,a.ID_Articulo as ID,a.activo as Activo FROM dbo.INMASY_Articulos a
                 JOIN dbo.INMASY_Usuarios u on a.uso_equipo = u.ID_Usuario
                 WHERE a.ID_Articulo = ?";
        $params = array($id);
        $stmt = sqlsrv_prepare($this->conexion, $query, $params);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $articulo = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        return $articulo;
    }
    public function editarArticulo($articulo)
    {
        sqlsrv_begin_transaction($this->conexion);
        $queryArticulo = "UPDATE dbo.INMASY_Articulos SET nombre = ?, marca = ?, modelo = ?, serial = ?, costo_unitario = ?, cantidad = ?, direccion = ?, activo = ? WHERE ID_Articulo = ?";
        $params = [
            $articulo['nombre'],
            $articulo['marca'],
            $articulo['modelo'],
            $articulo['serial'],
            $articulo['costo_unitario'],
            $articulo['cantidad'],
            $articulo['direccion'],
            $articulo['activo'],
            $articulo['ID_Articulo']
        ];
        $stmt = sqlsrv_prepare($this->conexion, $queryArticulo, $params);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);
            return ['error' => $errors[0]['message']];
        }

        switch ($articulo['categoria']) {
            case "reles":
                $queryCategoria = "UPDATE dbo.INMASY_Articulos SET atributos_especificos = ? WHERE ID_Articulo = ?";
                $atributos = json_encode(['tipo' => $articulo['tipo']]);
                $paramsCategoria = [
                    $atributos,
                    $articulo['ID_Articulo']
                ];
                $stmtCategoria = sqlsrv_prepare($this->conexion, $queryCategoria, $paramsCategoria);
                if (!sqlsrv_execute($stmtCategoria)) {
                    $errors = sqlsrv_errors();
                    sqlsrv_rollback($this->conexion);
                    return ['error' => $errors[0]['message']];
                }
                break;

            default:
                sqlsrv_rollback($this->conexion);
                return ['error' => 'Categoría no válida: ' . $articulo['categoria']];
        }
        sqlsrv_commit($this->conexion);
        return ['success' => true];
    }
    public function sacarArticulo($id) {}
    public function pedirArticulo($id) {}
}
