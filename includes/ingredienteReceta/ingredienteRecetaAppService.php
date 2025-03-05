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

    public function crearIngredienteReceta($ingredienteRecetaDTO)
    {
        $IIngredienteRecetaDAO = ingredienteRecetaFactory::CreateIngredienteReceta();

        $createdIngredienteRecetaDTO = $IIngredienteRecetaDAO->crearIngredienteReceta($ingredienteRecetaDTO);
    
        return $createdIngredienteRecetaDTO;
    }

    public function editarIngredienteReceta($ingredienteRecetaDTO)
    {
        $IIngredienteRecetaDAO = ingredienteRecetaFactory::CreateIngredienteReceta();

        $editedIngredienteRecetaDTO = $IIngredienteRecetaDAO->editarIngredienteReceta($ingredienteRecetaDTO);
    
        return $editedIngredienteRecetaDTO;
    }

    public function borrarIngredienteReceta($ingredienteRecetaDTO)
    {
        $IIngredienteRecetaDAO = ingredienteRecetaFactory::CreateIngredienteReceta();

        $deletedIngredienteRecetaDTO = $IIngredienteRecetaDAO->borrarIngredienteReceta($ingredienteRecetaDTO);
    
        return $deletedIngredienteRecetaDTO;
    }

}

?>