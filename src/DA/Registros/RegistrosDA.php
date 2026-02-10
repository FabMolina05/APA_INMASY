<?php

namespace DA\Registros;


require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/DA/IRegistrosDA.php";

use ABS\Interfaces\DA\IRegistrosDA;


class RegistrosDA implements IRegistrosDA
{
    private $conexion;

    public function __construct($conn)
    {

        $this->conexion = $conn;
    }

    public function totalRegistros()
    {
        $query = "SELECT *
                 FROM [PADDE].[dbo].[INMASY_vw_totalRegistros]
                 ";

        $stmt = sqlsrv_prepare($this->conexion, $query);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }

        $total = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $total;
    }
    public function totalPorCategoria()
    {
        $query = "{CALL dbo.INMASY_totalPorCategoria}";
        $stmt = sqlsrv_prepare($this->conexion, $query);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }

        $total = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $total;
    }
    public function totalCapital()
    {
        $query = "SELECT *
                 FROM [PADDE].[dbo].[INMASY_vw_totalCapital]
                 ";

        $stmt = sqlsrv_prepare($this->conexion, $query);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }

        $total = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $total;
    }
}
