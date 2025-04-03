<?php

namespace es\ucm\fdi\aw\entidades\ingredienteReceta;

interface IIngredienteReceta
{
    // Método para crear una nueva relación entre un ingrediente y una receta
    public function crearIngredienteReceta($ingredienteRecetaDTO);

    // Método para eliminar una relación entre un ingrediente y una receta
    public function borrarIngredienteReceta($recetaDTO);

    public function buscarIngredienteReceta($recetaDTO, $criterio);

}

?>
