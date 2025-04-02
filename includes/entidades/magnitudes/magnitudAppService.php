<?php

namespace es\ucm\fdi\aw\entidades\magnitudes;

class magnitudAppService
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

    public function crearMagnitud($etiquetaDTO)
    {
        //Implementar luego
    }

    public function editarMagnitud($etiquetaDTO)
    {
        //Implementar luego
    }

    public function borrarMagnitud($etiquetaDTO)
    {
        //Implementar luego
    }

}

?>