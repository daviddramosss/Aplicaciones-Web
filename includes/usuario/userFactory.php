<?php

require("userDAO.php");
require("userMock.php");

class userFactory
{
    //Permite asociar la creación de usuarios a esta clase exclusivamente
    public static function CreateUser() : IUser
    {
        /*$userDAO = false;

        if (true)
        {
            $userDAO = new userDAO();
        }
        else
        {
            $userDAO = new userMock();
        }
        
        return $userDAO;*/
        return new userDAO();
    }
}

?>