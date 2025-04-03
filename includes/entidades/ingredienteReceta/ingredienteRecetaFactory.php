<?php

namespace es\ucm\fdi\aw\entidades\ingredienteReceta;

// Clase Factory para crear instancias de IIngredienteReceta (en este caso, ingredienteRecetaDAO)
class ingredienteRecetaFactory
{
    // Método estático para crear una instancia de IIngredienteReceta
    // En este caso, retorna un objeto de la clase ingredienteRecetaDAO que implementa IIngredienteReceta
    public static function CreateIngredienteReceta() : IIngredienteReceta
    {
        $ingredienteRecetaDAO = false;

        // Creamos una nueva instancia de ingredienteRecetaDAO
        $ingredienteRecetaDAO = new ingredienteRecetaDAO();
               
        // Retornamos la instancia creada
        return $ingredienteRecetaDAO;
    }
}

?>
