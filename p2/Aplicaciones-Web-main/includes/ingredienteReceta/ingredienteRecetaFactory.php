<?php

require("ingredienteRecetaDAO.php");

class ingredienteRecetaFactory
{
    public static function CreateIngredienteReceta() : IIngredienteReceta
    {
        $ingredienteRecetaDAO = false;

        $ingredienteRecetaDAO = new ingrdienteRecetaDAO();
               
        return $ingredienteRecetaDAO;
    }
}

?>