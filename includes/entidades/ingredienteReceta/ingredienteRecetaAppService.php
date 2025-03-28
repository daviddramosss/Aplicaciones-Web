<?php

namespace es\ucm\fdi\aw\entidades\ingredienteReceta;
// require_once("ingredienteRecetaFactory.php");

// Clase que actúa como servicio de aplicación para gestionar la relación entre ingredientes y recetas
class IngredienteRecetaAppService
{
    // Propiedad estática para mantener una única instancia de la clase (patrón Singleton)
    private static $instance;

    // Método estático para obtener la instancia única de la clase
    public static function GetSingleton()
    {
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }
  
    // Constructor privado para evitar la instanciación directa de la clase
    private function __construct()
    {
    } 

    // Método para crear un ingrediente en una receta
    public function crearIngredienteReceta($ingredienteRecetaDTO)
    {
        $IIngredienteRecetaDAO = IngredienteRecetaFactory::CreateIngredienteReceta();

        $createdIngredienteRecetaDTO = $IIngredienteRecetaDAO->crearIngredienteReceta($ingredienteRecetaDTO);
    
        return $createdIngredienteRecetaDTO;
    }

    // Método para editar un ingrediente en una receta
    public function editarIngredienteReceta($ingredienteRecetaDTO)
    {
        $IIngredienteRecetaDAO = IngredienteRecetaFactory::CreateIngredienteReceta();

        $editedIngredienteRecetaDTO = $IIngredienteRecetaDAO->editarIngredienteReceta($ingredienteRecetaDTO);
    
        return $editedIngredienteRecetaDTO;
    }

    // Método para eliminar un ingrediente de una receta
    public function borrarIngredienteReceta($ingredienteRecetaDTO)
    {
        $IIngredienteRecetaDAO = IngredienteRecetaFactory::CreateIngredienteReceta();

        $deletedIngredienteRecetaDTO = $IIngredienteRecetaDAO->borrarIngredienteReceta($ingredienteRecetaDTO);
    
        return $deletedIngredienteRecetaDTO;
    }
}


?>
