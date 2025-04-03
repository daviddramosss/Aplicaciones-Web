<?php

namespace es\ucm\fdi\aw\entidades\ingredienteReceta;
// Clase que representa un objeto Data Transfer Object (DTO) para Ingredientes en una receta
class ingredienteRecetaDTO
{
    // Propiedades privadas para almacenar los datos de la receta, ingrediente, cantidad y magnitud
    private $recetaId;
    private $ingrediente;
    private $cantidad;
    private $magnitud;

    // Constructor que inicializa las propiedades de la clase
    public function __construct($recetaId, $ingrediente, $cantidad, $magnitud)
    {
        $this->recetaId = $recetaId;          // Id de la receta
        $this->ingrediente = $ingrediente; // Id del ingrediente
        $this->cantidad = $cantidad;           // Cantidad del ingrediente
        $this->magnitud = $magnitud;           // Magnitud de la cantidad (por ejemplo, 'gramos', 'litros', etc.)
    }

    // Métodos getter

    public function getRecetaId()
    {
        return $this->recetaId;
    }

    public function getIngrediente()
    {
        return $this->ingrediente;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getMagnitud()
    {
        return $this->magnitud;
    }
}

?>
