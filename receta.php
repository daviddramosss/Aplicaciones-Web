<?php

class Receta {
    private $id;
    private $titulo;
    private $precio;
    private $descripcion;

    public function __construct($id, $titulo, $precio, $descripcion) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public static function obtenerRecetasEnVenta() {
        $db = Config::getConexionDB();
        $query = $db->query("SELECT id, titulo, precio, descripcion FROM recetas WHERE en_venta = 1");
        $recetas = [];
        
        while ($datos = $query->fetch(PDO::FETCH_ASSOC)) {
            $recetas[] = new Receta($datos['id'], $datos['titulo'], $datos['precio'], $datos['descripcion']);
        }
        
        return $recetas;
    }
}

?>
