<?php

require("recetaFactory.php");

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

    public function create($recetaDTO)
    {
        $IRecetaDAO = recetaFactory::CreateReceta();

        $createdRecetaDTO = $IRecetaDAO->create($recetaDTO);

        return $createdRecetaDTO;
    }

    public function edit($recetaDTO)
    {
        $IRecetaDAO = recetaFactory::CreateReceta();

        $editedRecetaDTO = $IRecetaDAO->edit($recetaDTO);

        return $editedRecetaDTO;
    }

    public function delete($recetaDTO)
    {
        $IRecetaDAO = recetaFactory::CreateReceta();

        $deletedRecetaDTO = $IRecetaDAO->delete($recetaDTO);

        return $deletedRecetaDTO;
    }

}

?>