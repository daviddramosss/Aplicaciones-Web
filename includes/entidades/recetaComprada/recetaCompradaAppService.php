<?php

namespace es\ucm\fdi\aw\entidades\recetaComprada;

use es\ucm\fdi\aw\entidades\ingredienteReceta\{ingredienteRecetaFactory, ingredienteRecetaDTO};
use es\ucm\fdi\aw\entidades\etiquetaReceta\{etiquetaRecetaFactory, etiquetaRecetaDTO};

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


    public function mostarRecetasPorComprador($userDTO){
        $IRecetaCompradaDAO = recetaCompradaFactory::CreateReceta();

        return $IRecetaCompradaDAO->mostarRecetasPorComprador($userDTO);
        
    }
   
}

?>
