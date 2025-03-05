<?php

require_once("etiquetaRecetaFactory.php");

class etiquetaRecetaAppService
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

    public function crearEtiquetaReceta($etiquetaRecetaDTO)
    {
        $IEtiquetaRecetaDAO = etiquetaRecetaFactory::createEtiquetaReceta();

        $createdEtiquetaRecetaDTO = $IEtiquetaRecetaDAO->crearEtiquetaReceta($etiquetaRecetaDTO);

        return $createdEtiquetaRecetaDTO;
    }

    public function editarEtiquetaReceta($etiquetaRecetaDTO)
    {
        $IEtiquetaRecetaDAO = etiquetaRecetaFactory::createEtiquetaReceta();

        $editarEtiquetaRecetaDTO = $IEtiquetaRecetaDAO->editarEtiquetaReceta($etiquetaRecetaDTO);

        return $editarEtiquetaRecetaDTO;
    }

    public function borrarEtiquetaReceta($etiquetaRecetaDTO)
    {
        $IEtiquetaRecetaDAO = etiquetaRecetaFactory::createEtiquetaReceta();

        $deletedEtiquetaRecetaDTO = $IEtiquetaRecetaDAO->borrarEtiquetaReceta($etiquetaRecetaDTO);

        return $deletedEtiquetaRecetaDTO;
    }
}

?>