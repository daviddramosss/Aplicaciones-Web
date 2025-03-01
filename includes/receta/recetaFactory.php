<?php

require("recetaDAO.php");
require("recetaMock.php");

class recetaFactory
{
    public static function CreateReceta() : IReceta
    {
        $recetaDAO = false;

        $recetaDAO = new recetaDAO();
               
        return $recetaDAO;
    }
}

?>