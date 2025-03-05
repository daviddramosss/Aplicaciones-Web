<?php

require_once("ingredienteRecetaFactory.php");

class ingredienteRecetaAppService
{
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

    public function crearIngredienteReceta($ingredienteDTO)
    {

    }

    public function editarIngredienteReceta($ingredienteDTO)
    {

    }

    public function borrarIngredienteReceta($ingredienteDTO)
    {

    }

}

?>