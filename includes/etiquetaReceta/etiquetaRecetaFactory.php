<?php

require("etiquetaRecetaDAO.php");

class etiquetaRecetaFactory
{
    public static function createEtiquetaReceta() : IEtiquetaReceta
    {
        $etiquetaRecetaDAO = false;

        $etiquetaRecetaDAO = new etiquetaRecetaDAO();

        return $etiquetaRecetaDAO;
    }
}


?>