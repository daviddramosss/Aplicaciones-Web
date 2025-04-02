<?php

namespace es\ucm\fdi\aw\entidades\ingrediente;

// Definición de la clase IngredienteFactory
// Se encarga de la creación de instancias de la clase IngredienteDAO
class IngredienteFactory
{
    // Método estático para crear y devolver una instancia de IngredienteDAO
    public static function CreateIngrediente() : IIngrediente
    {
        // Variable para almacenar la instancia de IngredienteDAO
        $ingredienteDAO = false;

        // Se crea una nueva instancia de IngredienteDAO
        $ingredienteDAO = new IngredienteDAO();
               
        // Se retorna la instancia creada, asegurando que implementa IIngrediente
        return $ingredienteDAO;
    }
}

?>