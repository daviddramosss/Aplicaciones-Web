<?php

// Incluimos la fábrica de ingredientes, encargada de la creación de instancias de ingredientes
require_once("ingredienteFactory.php");

// Definimos la clase de servicio para gestionar ingredientes
class IngredienteAppService {

    // Variable estática para mantener una única instancia de la clase (patrón Singleton)
    private static $instance;

    // Método estático para obtener la instancia única de la clase
    public static function GetSingleton()
    {
        // Si la instancia no ha sido creada, se crea una nueva
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

    // Constructor privado para evitar la creación de instancias desde fuera de la clase
    private function __construct() 
    {               
    }

    // Método para crear un nuevo ingrediente (aún no implementado)
    public function crearIngrediente($ingredienteDTO)
    {
        // Implementar luego
    }

    // Método para editar un ingrediente existente (aún no implementado)
    public function editarIngrediente($ingredienteDTO)
    {
        // Implementar luego
    }

    // Método para eliminar un ingrediente (aún no implementado)
    public function eliminarIngrediente($ingredienteDTO)
    {
        // Implementar luego
    }

    // Método para obtener la lista de ingredientes desde la base de datos
    public function obtenerIngredientes()
    {
        // Se obtiene una instancia de la clase que maneja los ingredientes a través de la fábrica
        $IIngredienteDAO = ingredienteFactory::CreateIngrediente();

        // Se llama al método que obtiene los ingredientes y se devuelve el resultado
        return $IIngredienteDAO->obtenerIngredientes();
    }
}

// **Endpoint para obtener los ingredientes en formato JSON**
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'obtenerIngredientes') {
    
    // Se especifica que la respuesta será en formato JSON
    header('Content-Type: application/json');
    
    // Se obtiene la lista de ingredientes desde el servicio
    $ingredientes = IngredienteAppService::GetSingleton()->obtenerIngredientes();
    
    // Se convierte el resultado a JSON y se envía como respuesta
    echo json_encode($ingredientes);
    exit;
}
