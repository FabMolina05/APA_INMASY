<?php

namespace DA\Bitacora;


require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/DA/IBitacoraDA.php";

use ABS\Interfaces\DA\IBitacoraDA;
use Dom\Element;
use Exception;

class BitacoraDA implements IBitacoraDA
{
    private $conexion;

    public function __construct($conn)
    {

        $this->conexion = $conn;
    }
    public function obtenerBitacora()
    {
        $query = "SELECT b.ID_Bitacora, u.nombre_completo as usuario,b.categoria,b.fecha,b.descripcion,b.accion,b.estado
                  FROM dbo.INMASY_Bitacora b
                  JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = b.id_usuario";
        $stmt = sqlsrv_prepare($this->conexion, $query);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $bitacora = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $bitacora[] = $row;
        }

        return $bitacora;
    }
    public function obtenerBitacoraPorId($id)
    {
        $query = "SELECT b.ID_Bitacora, u.nombre_completo as usuario,b.categoria,b.fecha,b.descripcion,b.accion,b.estado
                  FROM dbo.INMASY_Bitacora b
                  JOIN dbo.INMASY_Usuarios u ON u.ID_Usuario = b.id_usuario
                  WHERE b.ID_Bitacora = ?";
        $param = [$id];
        $stmt = sqlsrv_prepare($this->conexion, $query, $param);
        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $bitacora = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);


        return $bitacora;
    }
    public function registrarBitacora($bitacora)
    {
        sqlsrv_begin_transaction($this->conexion);
        $query = "INSERT INTO dbo.INMASY_Bitacora (id_usuario,categoria,fecha,descripcion,accion,estado)
                VALUES (?,?,?,?,?,?)";
        $param = [
            $bitacora['id_usuario'],
            $bitacora['categoria'],
            $bitacora['fecha'],
            $bitacora['descripcion'],
            $bitacora['accion'],
            $bitacora['estado']
            
        ];
        $stmt = sqlsrv_query($this->conexion, $query, $param);
        if ($stmt==false) {
            $errors = sqlsrv_errors();
            sqlsrv_rollback($this->conexion);
            throw new Exception("error al registrar bitacora".$errors[0]['message']);
        }
        sqlsrv_commit($this->conexion);


        
    }
}
