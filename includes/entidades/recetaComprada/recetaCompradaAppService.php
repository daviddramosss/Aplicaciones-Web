<?php

namespace es\ucm\fdi\aw\entidades\recetaComprada;

class recetaCompradaAppService
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


    public function mostrarRecetasPorComprador($recetaCompradaDTO){
        $IRecetaCompradaDAO = recetaCompradaFactory::CreateReceta();

        return $IRecetaCompradaDAO->mostrarRecetasPorComprador($recetaCompradaDTO);
        
    }

    public function comprarReceta($recetaCompradaDTO){
        $IRecetaCompradaDAO = recetaCompradaFactory::CreateReceta();

        return $IRecetaCompradaDAO->comprarReceta($recetaCompradaDTO);
        
    }

    public function esComprador($recetaCompradaDTO){
        $IRecetaCompradaDAO = recetaCompradaFactory::CreateReceta();

        return $IRecetaCompradaDAO->esComprador($recetaCompradaDTO);
    }
   
}

?>
