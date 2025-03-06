<?php

/**
 * Clase DTO (Data Transfer Object) para representar una relación entre una receta y una etiqueta.
 * Se usa para transferir datos entre capas de la aplicación sin exponer directamente la estructura de la base de datos.
 */
class etiquetaRecetaDTO
{
    private $etiqueta;  // Nombre de la etiqueta asociada a la receta
    private $recetaId;  // ID de la receta asociada a la etiqueta

    /**
     * Constructor de la clase.
     * @param int $recetaId ID de la receta a la que pertenece la etiqueta.
     * @param string $etiqueta Nombre de la etiqueta asociada.
     */
    public function __construct($recetaId, $etiqueta)
    {        
        $this->recetaId = $recetaId;
        $this->etiqueta = $etiqueta;
    }

    /**
     * Método para obtener el nombre de la etiqueta.
     * @return string Nombre de la etiqueta.
     */
    public function getEtiqueta()
    {
        return $this->etiqueta;
    }

    /**
     * Método para obtener el ID de la receta asociada.
     * @return int ID de la receta.
     */
    public function getRecetaId()
    {
        return $this->recetaId;
    }
}

?>
