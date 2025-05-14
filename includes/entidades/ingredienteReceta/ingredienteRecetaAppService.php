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

    public function buscarIngredienteReceta($recetaDTO, $criterio)
    {
        $IIngredienteRecetaDAO = ingredienteRecetaFactory::CreateIngredienteReceta();

        return $IIngredienteRecetaDAO->buscarIngredienteReceta($recetaDTO, $criterio);
    }
}


?>
