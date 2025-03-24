<?php

require_once("etiquetasFactory.php");

class etiquetasAppService
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

    public function crearEtiqueta($etiquetaDTO)
    {
        //Implementar luego
    }

    public function editarEtiqueta($etiquetaDTO)
    {
        //Implementar luego
    }

    public function borrarEtiqueta($etiquetaDTO)
    {
        //Implementar luego
    }

    public function mostrarEtiqueta()
    {
        $IEtiquetasDAO = etiquetasFactory::GetSingleton()->CreateEtiquetas();

        $etiquetas = $IEtiquetasDAO->mostrarEtiqueta();

        return $etiquetas;
    }


}

?>