<?php

namespace es\ucm\fdi\aw\entidades\ingredienteReceta;

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

    // Método para eliminar un ingrediente de una receta
    public function borrarIngredienteReceta($recetaDTO)
    {
        $IIngredienteRecetaDAO = IngredienteRecetaFactory::CreateIngredienteReceta();

        $deletedIngredienteRecetaDTO = $IIngredienteRecetaDAO->borrarIngredienteReceta($recetaDTO);
    
        return $deletedIngredienteRecetaDTO;
    }


    public function buscarIngredienteReceta($recetaDTO, $criterio)
    {
        $IIngredienteRecetaDAO = IngredienteRecetaFactory::CreateIngredienteReceta();

        return $IIngredienteRecetaDAO->buscarIngredienteReceta($recetaDTO, $criterio);
    }
}


?>
