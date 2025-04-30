<?php

namespace es\ucm\fdi\aw\entidades\recetaComprada;

class recetaCompradaFactory
{

    //Método estático que crea y devuelve una instancia de recetaDAO.
    public static function CreateReceta(): IRecetaComprada
    {
        // Inicializa la variable con un valor por defecto (innecesario aquí)
        $recetaCompradaDAO = false;

        // Crea una nueva instancia de recetaDAO
        $recetaCompradaDAO = new recetaCompradaDAO();
               
        return $recetaCompradaDAO;
    }
}

?>
