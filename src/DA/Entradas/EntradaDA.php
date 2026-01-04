<?php

namespace DA\Entradas;

require_once __DIR__ . '/../../ABS/Interfaces/DA/IEntradaDA.php';

use ABS\Interfaces\DA\IEntradaDA;

class EntradaDA implements IEntradaDA
{
    private $conexion;

    public function __construct($conn)
    {
        $this->conexion = $conn;
    }

    public function agregarArticulo($articulo, $adquisicion, $categoria)
    {
        // Implementación para agregar un artículo
    }

    public function editarEntrada($entrada)
    {
        // Implementación para editar una entrada
    }

    public function obtenerEntradas()
    {
        // Implementación para obtener entradas
    }
    public function obtenerCategorias()
    {
        $query = "SELECT ID_Categoria as id, nombre_categoria as nombre FROM dbo.INMASY_Categoria";
        $stmt = sqlsrv_prepare($this->conexion, $query);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $categorias = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $categorias[] = $row;
        }

        return $categorias;
    }
    public function obtenerProveedores()
    {
        $query = "SELECT ID_Proveedor as id ,nombre , telefono , correo, direccion FROM dbo.INMASY_Proveedores";
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
}
