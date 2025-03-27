<?php

namespace es\ucm\fdi\aw\entidades\receta;
// require("recetaDAO.php");

class recetaFactory
{

    //Método estático que crea y devuelve una instancia de recetaDAO.
    public static function CreateReceta(): IReceta
    {
        // Inicializa la variable con un valor por defecto (innecesario aquí)
        $recetaDAO = false;

        // Crea una nueva instancia de recetaDAO
        $recetaDAO = new recetaDAO();
               
        return $recetaDAO;
    }
}

?>
