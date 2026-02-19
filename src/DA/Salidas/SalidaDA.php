<?php

namespace DA\Salidas;

require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/DA/ISalidaDA.php";

use ABS\Interfaces\DA\ISalidaDA;
use DA\Context\DBContext;

class SalidaDA implements ISalidaDA
{
    private $conexion;

    public function __construct($conn)
    {

        $this->conexion = $conn;
    }

    public function obtenerSalidas()
    {
        $query = " SELECT 
       s.motivo,
       s.fecha_salida as salida,
        s.ID_Salida as id,
       a.nombre,
       a.serial,
       c.nombre_categoria as categoria
        FROM dbo.INMASY_SalidasCTM s
        JOIN dbo.INMASY_Inventario i ON i.ID_Inventario = s.id_inventario
        JOIN dbo.INMASY_Articulos a ON a.ID_Articulo = i.id_articulo
        JOIN dbo.INMASY_Categorias c on c.ID_Categoria = a.id_categoria
        ORDER BY s.ID_Salida DESC
        ";
       
        $stmt = sqlsrv_prepare($this->conexion, $query);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }

        $salida = [];
         while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $salida[] = $row;
        }
        return $salida;
    }
    public function obtenerSalidaPorID($salida) {
        $query = "{CALL dbo.INMASY_obtenerSalientePorId(?)}";
        $param = array($salida);
        $stmt = sqlsrv_prepare($this->conexion, $query, $param);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }

        $salida = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $salida;
    }

}
