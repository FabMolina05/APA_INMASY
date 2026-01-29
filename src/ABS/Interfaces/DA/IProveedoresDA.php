<?php 
namespace ABS\Interfaces\DA;

interface IProveedoresDA {
    public function agregarProveedor($proveedor);
    public function actualizarProveedor($proveedor);
    public function obtenerProveedores();
    public function obtenerProveedorPorId($id);

}



?>