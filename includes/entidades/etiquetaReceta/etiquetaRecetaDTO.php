<?php

namespace es\ucm\fdi\aw\entidades\etiquetaReceta;
/**
 * Clase DTO (Data Transfer Object) para representar una relación entre una receta y una etiqueta.
 * Se usa para transferir datos entre capas de la aplicación sin exponer directamente la estructura de la base de datos.
 */
class etiquetaRecetaDTO
{
    private $etiquetaId;  // ID de la etiqueta asociada a la receta
    private $recetaId;  // ID de la receta asociada a la etiqueta

    // Constructor de la clase.
    public function __construct($recetaId, $etiquetaId)
    {        
        $this->recetaId = $recetaId;
        $this->etiquetaId = $etiquetaId;
    }

    // Método para obtener el nombre de la etiqueta.
    public function getEtiqueta()
    {
        return $this->etiquetaId;
    }

    // Método para obtener el ID de la receta asociada.
    public function getRecetaId()
    {
        return $this->recetaId;
    }
}

?>
