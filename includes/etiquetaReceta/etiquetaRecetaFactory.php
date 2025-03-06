<?php

require("etiquetaRecetaDAO.php"); // Se requiere la clase que implementa el acceso a datos de etiquetas de recetas.

/**
 * Fábrica para la creación de objetos que implementan la interfaz IEtiquetaReceta.
 * Permite desacoplar la creación de instancias del código que las utiliza, facilitando la inyección de dependencias y la sustitución de implementaciones.
 */
class etiquetaRecetaFactory
{
    /**
     * Método estático para crear una instancia de etiquetaRecetaDAO.
     * @return IEtiquetaReceta Instancia de etiquetaRecetaDAO que implementa IEtiquetaReceta.
     */
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
