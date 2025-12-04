<?php 

namespace ABS\Modelos;
class Usuarios {
    public $id;
    public $nombre;
    public Rol $rol;
    

    public function __construct($id, $nombre, $rol)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->rol = $rol;
    }
}