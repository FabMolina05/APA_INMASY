<?php

namespace DA\Inventario;
require_once dirname(__DIR__, 3) . "/src/ABS/Interfaces/DA/IInventarioDA.php";

use ABS\Interfaces\DA\IInventarioDA;

class InventarioDA implements IInventarioDA{
    private $conexion;

    public function __construct($conn)
    {
        $this->conexion = $conn;
    }

    public function obtenerReles(){
        $query = "SELECT a.ID_Articulo,a.id_caja,a.modelo,a.marca,a.nombre,a.disponibilidad,a.activo,r.tipo FROM dbo.INMASY_Reles r 
                 JOIN dbo.INMASY_Articulos a on r.id_articulo = a.ID_Articulo";
        $stmt = sqlsrv_prepare($this->conexion,$query);

        if (!sqlsrv_execute($stmt)) {
            $errors = sqlsrv_errors();
            return ['error' => $errors[0]['message']];
        }
        $reles[] = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);


        return $reles;
                
    }
    public function obtenerEquipoElectronico(){

    }
    public function obtenerCables(){

    }
    public function obtenerComunicaciones(){

    }
    public function obtenerGabinetes(){

    }
    public function obtenerTarjetas(){

    }
    public function obtenerOtros(){

    }
    public function obtenerArticuloPorId($categoria, $id){

    }
    public function editarArticulo($categoria, $id){

    }
    public function sacarArticulo($id){

    }
    public function pedirArticulo($id){

    }
    public function agregarArticulo(){

    }
}