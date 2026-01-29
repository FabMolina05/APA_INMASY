<?php 
namespace ABS\Interfaces\BL;

interface IProveedoresBL {
    public function agregarProveedor($proveedor);
    public function actualizarProveedor($proveedor);
    public function obtenerProveedores();
    public function obtenerProveedorPorId($id);

}
    


?>