<?php
namespace es\ucm\fdi\aw\entidades\ingrediente;

class IngredienteDTO {

    private $id;
    private $nombre;

    // Constructor de la clase
    public function __construct($id, $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    // Métodos para obtener los valores
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    // Métodos para establecer los valores
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}
?>
