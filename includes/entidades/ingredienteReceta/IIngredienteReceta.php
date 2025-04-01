<?php

namespace es\ucm\fdi\aw\entidades\ingredienteReceta;
// Definición de la interfaz IIngredienteReceta
// Esta interfaz define los métodos que deben implementarse para gestionar ingredientes en recetas
interface IIngredienteReceta
{
    // Método para crear una nueva relación entre un ingrediente y una receta
    public function crearIngredienteReceta($ingredienteReceta);

    // Método para editar una relación existente entre un ingrediente y una receta
    public function editarIngredienteReceta($ingredienteReceta);

    // Método para eliminar una relación entre un ingrediente y una receta
    public function borrarIngredienteReceta($ingredienteReceta);

}

?>
