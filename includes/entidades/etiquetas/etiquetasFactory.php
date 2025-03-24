<?php

require("etiquetasDAO.php");

class etiquetasFactory
{
    //Método estático que crea y devuelve una instancia de etiquetasDAO.
    public static function CreateEtiquetas(): IEtiquetas
    {
        // Inicializa la variable con un valor por defecto (innecesario aquí)
        $etiquetasDAO = false;

        // Crea una nueva instancia de etiquetasDAO
        $etiquetasDAO = new etiquetasDAO();
               
        return $etiquetasDAO;
    }
}

?>