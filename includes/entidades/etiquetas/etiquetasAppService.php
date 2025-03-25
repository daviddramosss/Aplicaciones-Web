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

    public function mostrarEtiquetas()
    {
        $IEtiquetasDAO = etiquetasFactory::CreateEtiquetas();

        return $IEtiquetasDAO->mostrarEtiquetas();

    }


}

// **Endpoint para obtener los etiquetas en formato JSON**
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'mostrarEtiquetas') {
    
    // Se especifica que la respuesta será en formato JSON
    header('Content-Type: application/json');
    
    // Se obtiene la lista de etiquetas desde el servicio
    $etiquetas = EtiquetasAppService::GetSingleton()->mostrarEtiquetas();
    
    // Se convierte el resultado a JSON y se envía como respuesta
    echo json_encode($etiquetas);
    exit;
}

?>