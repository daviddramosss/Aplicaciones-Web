<?php

// Importa la clase recetaDAO, que implementa la interfaz IReceta
require("recetaDAO.php");

class recetaFactory
{
    /**
     * Método estático que crea y devuelve una instancia de recetaDAO.
     * @return IReceta Una instancia de recetaDAO que implementa IReceta.
     */
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
