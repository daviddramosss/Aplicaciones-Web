<?php

namespace es\ucm\fdi\aw\entidades\chef;

class chefFactory 
{

    public static function createChef() : IChef
    {
        // Inicializa la variable (aunque la asignación previa a false no es necesaria en este caso)
        $chefDAO = false;

        // Crea una nueva instancia de chefDAO
        $chefDAO = new chefDAO();

        return $chefDAO;
    }

}

?>