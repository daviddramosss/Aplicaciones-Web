<?php

namespace es\ucm\fdi\aw\entidades\magnitudes;
// require("magnitudDAO.php");

class magnitudFactory
{
    //Método estático que crea y devuelve una instancia de magnitudDAO.
    public static function CreateMagnitud(): IMagnitud
    {
        // Inicializa la variable con un valor por defecto (innecesario aquí)
        $magnitudDAO = false;

        // Crea una nueva instancia de magnitudDAO
        $magnitudDAO = new magnitudDAO();
               
        return $magnitudDAO;
    }
}

?>