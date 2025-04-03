<?php

namespace es\ucm\fdi\aw\entidades\ingredienteReceta;

interface IIngredienteReceta
{
    // Método para crear una nueva relación entre un ingrediente y una receta
    public function crearIngredienteReceta($ingredienteReceta);

    // Método para eliminar una relación entre un ingrediente y una receta
    public function borrarIngredienteReceta($recetaId);

    public function buscarIngredienteReceta($recetaId);

}

?>
