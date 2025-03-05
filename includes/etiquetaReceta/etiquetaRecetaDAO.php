<?php

require_once("IEtiquetaReceta.php");
require_once("etiquetaRecetaDTO.php");
require_once(__DIR__ . "/../comun/baseDAO.php");

class etiquetaRecetaDAO extends baseDAO implements IEtiquetaReceta
{
    public function __construct()
    {
        
    }

    public function crearEtiquetaReceta($etiquetaRecetaDTO)
    {
        
    }

    public function editarEtiquetaReceta($etiquetaRecetaDTO)
    {
        //Implementar más adelante
    }

    public function borrarEtiquetaReceta($etiquetaRecetaDTO)
    {
        //Implementar más adelante
    }
}



?>