<?php

require_once("recetaFactory.php");

class recetaAppService
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

    public function crearReceta($recetaDTO, $ingredientes, $etiquetas)
    {
        $IRecetaDAO = recetaFactory::CreateReceta();

        $createdRecetaDTO = $IRecetaDAO->crearReceta($recetaDTO, $ingredientes, $etiquetas);

        return $createdRecetaDTO;
    }

    public function editarReceta($recetaDTO)
    {
        $IRecetaDAO = recetaFactory::CreateReceta();

        $editedRecetaDTO = $IRecetaDAO->editarReceta($recetaDTO);

        return $editedRecetaDTO;
    }

    public function borrarReceta($recetaDTO)
    {
        $IRecetaDAO = recetaFactory::CreateReceta();

        $deletedRecetaDTO = $IRecetaDAO->borrarReceta($recetaDTO);

        return $deletedRecetaDTO;
    }

}

?>