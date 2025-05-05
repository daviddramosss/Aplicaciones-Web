<?php

namespace es\ucm\fdi\aw\entidades\etiquetaReceta;
// require("etiquetaRecetaDAO.php"); 

/**
 * Fábrica para la creación de objetos que implementan la interfaz IEtiquetaReceta.
 * Permite desacoplar la creación de instancias del código que las utiliza, facilitando la inyección de dependencias y la sustitución de implementaciones.
 */
class etiquetaRecetaFactory
{
    // Método estático para crear una instancia de etiquetaRecetaDAO.
    public static function createEtiquetaReceta() : IEtiquetaReceta
    {
        // Inicializa la variable (aunque la asignación previa a false no es necesaria en este caso)
        $etiquetaRecetaDAO = false;

        // Crea una nueva instancia de etiquetaRecetaDAO
        $etiquetaRecetaDAO = new etiquetaRecetaDAO();

        return $etiquetaRecetaDAO;
    }
}

?>
