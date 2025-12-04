<?php 
namespace ABS\Modelos;
class Articulo {
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock;

    public function __construct($id, $nombre, $descripcion, $precio, $stock)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
    }
}


?>