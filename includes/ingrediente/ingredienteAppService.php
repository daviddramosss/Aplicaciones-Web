<?php

require("ingredienteFactory.php");

class IngredienteAppService {

    private static $instance;

    public static function GetSingleton()
    {
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __construct() 
    {               
    }

    public function crearIngrediente($ingredienteDTO)
    {
        //Implementar luego
    }

    public function editarIngrediente($ingredienteDTO)
    {
        //Implementar luego
    }

    public function eliminarIngrediente($ingredienteDTO)
    {
        //Implementar luego
    }

    public function obtenerIngredientes()
    {
        $IIngredienteDAO = ingredienteFactory::CreateIngrediente();
        return $IIngredienteDAO->obtenerIngredientes();
    }
}

// **Endpoint para obtener los ingredientes en formato JSON**
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'obtenerIngredientes') {
    header('Content-Type: application/json');
    $ingredientes = IngredienteAppService::GetSingleton()->obtenerIngredientes();
    echo json_encode($ingredientes);
    exit;
}
