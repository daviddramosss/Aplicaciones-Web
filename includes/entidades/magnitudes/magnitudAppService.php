<?php

require_once("magnitudFactory.php");

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

    public function mostrarMagnitudes()
    {
        $IMagnitudesDAO = magnitudFactory::CreateMagnitud();

        return $IMagnitudesDAO->mostrarMagnitudes();

    }


}

// **Endpoint para obtener los magnitudes en formato JSON**
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'mostrarMagnitudes') {
    
    // Se especifica que la respuesta será en formato JSON
    header('Content-Type: application/json');
    
    // Se obtiene la lista de magnitudes desde el servicio
    $magnitudes = MagnitudAppService::GetSingleton()->mostrarMagnitudes();
    
    // Se convierte el resultado a JSON y se envía como respuesta
    echo json_encode($magnitudes);
    exit;
}

?>