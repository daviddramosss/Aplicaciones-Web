<?php

requir("ingredienteFactory.php");

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

        $buscarIngredienteDTO = $IIngredienteDAO->obtenerIngredientes();

        return $buscarIngredienteDTO;
    }
}
?>
