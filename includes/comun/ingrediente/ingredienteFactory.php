<?php

require("ingredienteDAO.php");

class ingredienteFactory
{
    public static function CreateIngrediente() : IIngrediente
    {
        $ingredienteDAO = false;

        $ingredienteDAO = new ingredienteDAO();
               
        return $ingredienteDAO;
    }
}

?>