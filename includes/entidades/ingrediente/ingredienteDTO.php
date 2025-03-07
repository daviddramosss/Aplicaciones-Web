<?php

// Definición de la clase IngredienteDTO (Data Transfer Object)
// Se usa para transportar datos de ingredientes entre capas de la aplicación
class IngredienteDTO 
{
    // Atributo para almacenar el ID del ingrediente
    private $id;

    // Atributo para almacenar el nombre del ingrediente
    private $nombre;

    // Atributo para indicar si el ingrediente ha sido verificado
    private $verificado;

    // Constructor de la clase que inicializa el ID y el nombre del ingrediente
    public function __construct($id, $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    // Método para obtener el ID del ingrediente
    public function getId() 
    {
        return $this->id;
    }

    // Método para obtener el nombre del ingrediente
    public function getNombre() 
    {
        return $this->nombre;
    }

    // Método para obtener el estado de verificación del ingrediente
    public function getVerificado()
    {
        return $this->verificado;
    }
}
?>
