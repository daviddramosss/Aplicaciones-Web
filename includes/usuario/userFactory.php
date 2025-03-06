<?php

require_once("userDAO.php");

class userFactory
{
    //Permite asociar la creación de usuarios a esta clase exclusivamente
    //Aisla y centraliza la lógica de creación de usuarios
    public static function CreateUser() : IUser
    {
        //Devuelve un usuario en formato DAO
        return new userDAO();
    }
}

?>