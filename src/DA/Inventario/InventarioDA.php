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
        
        switch ($categoria) {
            case "reles":
                $query = "SELECT a.id_caja as CAJA,a.nombre as Nombre,ISNULL(u.nombre_completo,'Sin ocupar') as Tecnico,a.modelo as Modelo,a.serial as Serial,a.estado as Estado,a.marca as  Marca,IIF(a.disponibilidad<1,'Libre','Ocupado') as Disponibilidad,a.direccion as Direccion,a.costo_unitario as Costo,a.cantidad as Cantidad,r.tipo FROM dbo.INMASY_Reles r 
                 JOIN dbo.INMASY_Articulos a on r.id_articulo = a.ID_Articulo 
                 JOIN dbo.INMASY_Usuarios u on a.uso_equipo = u.ID_Usuario
                 WHERE a.ID_Articulo = ?";
                 $params = array($id);
                 $stmt = sqlsrv_prepare($this->conexion,$query,$params);

                if (!sqlsrv_execute($stmt)) {
                    $errors = sqlsrv_errors();
                    return ['error' => $errors[0]['message']];
                }
                $articulo = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                return $articulo;
                break;
            case 'equipo_electronico':
                $table = 'INMASY_EquipoElectronico';
                break;
            case 'cables':
                $table = 'INMASY_Cables';
                break;
            case 'comunicaciones':
                $table = 'INMASY_Comunicaciones';
                break;
            case 'gabinetes':
                $table = 'INMASY_Gabinetes';
                break;
            case 'tarjetas':
                $table = 'INMASY_Tarjetas';
                break;
            case 'otros':
                $table = 'INMASY_Otros';
                break;
            default:
                return ['error' => 'Categoría no válida: ' . $categoria];
        }
        
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