<?php

namespace es\ucm\fdi\aw\entidades\etiquetaReceta;
/**
 * Interfaz IEtiquetaReceta
 * Define los métodos que deben implementar las clases encargadas de gestionar la relación entre recetas y etiquetas en la base de datos.
 */
interface IEtiquetaReceta
{
    // Crea una nueva relación entre una receta y una etiqueta.
    public function crearEtiquetaReceta($etiquetaRecetaDTO);

    // Edita una relación existente entre una receta y una etiqueta.
    public function editarEtiquetaReceta($etiquetaRecetaDTO);

    // Borra una relación entre una receta y una etiqueta.
    public function borrarEtiquetaReceta($etiquetaRecetaDTO);
}

?>
