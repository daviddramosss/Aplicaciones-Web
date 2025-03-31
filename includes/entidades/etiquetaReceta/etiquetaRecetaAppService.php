<?php

namespace es\ucm\fdi\aw\entidades\etiquetaReceta;
// require_once("etiquetaRecetaFactory.php");

class etiquetaRecetaAppService
{
    private static $instance; // Variable estática para almacenar la única instancia de la clase (patrón Singleton)

    // Método para obtener la única instancia de la clase (Singleton).
    public static function GetSingleton()
    {
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }
  
    // Constructor privado para evitar la creación de instancias fuera de la clase (Singleton).
    private function __construct()
    {
    } 

    // Método para crear una nueva etiqueta de receta.
    public function crearEtiquetaReceta($etiquetaRecetaDTO)
    {
        // Se obtiene una instancia de la interfaz de acceso a datos (DAO) mediante la fábrica
        $IEtiquetaRecetaDAO = etiquetaRecetaFactory::createEtiquetaReceta();

        // Se delega la creación de la etiqueta al DAO
        $createdEtiquetaRecetaDTO = $IEtiquetaRecetaDAO->crearEtiquetaReceta($etiquetaRecetaDTO);

        return $createdEtiquetaRecetaDTO;
    }

    // Método para editar una etiqueta de receta existente.
    public function editarEtiquetaReceta($etiquetaRecetaDTO)
    {
        // Se obtiene una instancia de la interfaz de acceso a datos (DAO) mediante la fábrica
        $IEtiquetaRecetaDAO = etiquetaRecetaFactory::createEtiquetaReceta();

        // Se delega la creación de la etiqueta al DAO
        $editarEtiquetaRecetaDTO = $IEtiquetaRecetaDAO->editarEtiquetaReceta($etiquetaRecetaDTO);

        return $editarEtiquetaRecetaDTO;
    }

    // Método para borrar una etiqueta de receta.
    public function borrarEtiquetaReceta($etiquetaRecetaDTO)
    {
        // Se obtiene una instancia de la interfaz de acceso a datos (DAO) mediante la fábrica
        $IEtiquetaRecetaDAO = etiquetaRecetaFactory::createEtiquetaReceta();

        // Se delega la creación de la etiqueta al DAO
        $deletedEtiquetaRecetaDTO = $IEtiquetaRecetaDAO->borrarEtiquetaReceta($etiquetaRecetaDTO);

        return $deletedEtiquetaRecetaDTO;
    }

    public function buscarEtiquetaReceta($recetaId)
    {
        $IEtiquetaRecetaDAO = etiquetaRecetaFactory::createEtiquetaReceta();
        return $IEtiquetaRecetaDAO->buscarEtiquetasReceta($recetaId);
    }
}

?>