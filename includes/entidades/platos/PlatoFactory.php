<?php

namespace es\ucm\fdi\aw\entidades\plato;

class PlatoFactory
{
    // Método estático para crear y devolver una instancia de PlatoDAO
    public static function CreatePlato(): IPlato
    {
        // Se crea una nueva instancia de PlatoDAO
        $platoDAO = new PlatoDAO();

        // Se retorna la instancia creada, asegurando que implementa IPlato
        return $platoDAO;
    }
}
?>
