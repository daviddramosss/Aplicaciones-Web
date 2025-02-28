<?php

require("recetaDAO.php");
require("recetaMock.php");

class recetaFactory
{
    public static function CreateReceta() : IReceta
    {
        $recetaDAO = false;

        if (true)
        {
            $recetaDAO = new recetaDAO();
        }
        else
        {
            $recetaDAO = new recetMock();
        }
        
        return $recetaDAO;
    }
}

?>