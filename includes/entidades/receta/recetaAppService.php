<?php

namespace es\ucm\fdi\aw\entidades\receta;

use es\ucm\fdi\aw\entidades\ingredienteReceta\{ingredienteRecetaAppService, ingredienteRecetaDTO};
use es\ucm\fdi\aw\entidades\etiquetaReceta\{etiquetaRecetaAppService, etiquetaRecetaDTO};

class recetaAppService
{
    private static $instance; 

    // Método estático que devuelve la única instancia de la clase (patrón Singleton)
    public static function GetSingleton()
    {
        // Si no se ha creado una instancia de la clase, la crea
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        // Retorna la instancia única de la clase
        return self::$instance;
    }
  
    // Constructor privado para evitar instanciaciones directas
    private function __construct()
    {
    } 

    // Método para crear una receta
    public function crearReceta($recetaDTO)
    {
        // Crea el objeto IRecetaDAO utilizando la fábrica (factory)
        $IRecetaDAO = recetaFactory::CreateReceta();

        // Llama al método 'crearReceta' del DAO para insertar la receta en la base de datos
        $createdRecetaDTO = $IRecetaDAO->crearReceta($recetaDTO);

        // Devuelve el objeto DTO creado
        return $createdRecetaDTO;
    }

    // Método para editar una receta
    public function editarReceta($recetaDTO)
    {
        // Crea el objeto IRecetaDAO utilizando la fábrica (factory)
        $IRecetaDAO = recetaFactory::CreateReceta();

        // Llama al método 'editarReceta' del DAO para actualizar la tabla receta en la base de datos
        return $IRecetaDAO->editarReceta($recetaDTO); 
    }

    // Método para borrar una receta
    public function borrarReceta($recetaDTO)
    {
        // Crea el objeto IRecetaDAO utilizando la fábrica (factory)
        $IRecetaDAO = recetaFactory::CreateReceta();

        // Llama al método 'borrarReceta' del DAO para eliminar la receta de la base de datos
        $deletedRecetaDTO = $IRecetaDAO->borrarReceta($recetaDTO); 

        // Devuelve el objeto DTO borrado
        return $deletedRecetaDTO;
    }

    public function mostarRecetasPorAutor($userDTO){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->mostarRecetasPorAutor($userDTO);
        
    }

    public function mostarRecetasPorComprador($userDTO){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->mostarRecetasPorComprador($userDTO);
        
    }


    public function mostrarRecetas($criterio){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->mostrarRecetas($criterio);
    }

    public function buscarRecetaPorId($recetaDTO){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->buscarReceta($recetaDTO);
    }

    public function buscarRecetasConEtiquetas($etiquetas, $idRecetaActual) {
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->buscarRecetasConEtiquetas($etiquetas, $idRecetaActual);
    }
}

?>
