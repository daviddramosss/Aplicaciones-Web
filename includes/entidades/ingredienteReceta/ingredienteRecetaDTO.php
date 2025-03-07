<?php

// Clase que representa un objeto Data Transfer Object (DTO) para Ingredientes en una receta
class ingredienteRecetaDTO
{
    // Propiedades privadas para almacenar los datos de la receta, ingrediente, cantidad y magnitud
    private $recetaId;
    private $ingredienteId;
    private $cantidad;
    private $magnitud;

    // Constructor que inicializa las propiedades de la clase
    public function __construct($recetaId, $ingredienteId, $cantidad, $magnitud)
    {
        $this->recetaId = $recetaId;          // Id de la receta
        $this->ingredienteId = $ingredienteId; // Id del ingrediente
        $this->cantidad = $cantidad;           // Cantidad del ingrediente
        $this->magnitud = $magnitud;           // Magnitud de la cantidad (por ejemplo, 'gramos', 'litros', etc.)
    }

    // Métodos getter para acceder a las propiedades privadas

    // Devuelve el id de la receta
    public function getRecetaId()
    {
        return $this->recetaId;
    }

    // Devuelve el id del ingrediente
    public function gerIngredienteId()
    {
        return $this->ingredienteId;
    }

    // Devuelve la cantidad del ingrediente
    public function getCantidad()
    {
        return $this->cantidad;
    }

    // Devuelve la magnitud de la cantidad del ingrediente
    public function getMagnitud()
    {
        return $this->magnitud;
    }
}

?>
