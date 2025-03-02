<?php

require_once("userFactory.php");
require_once("userDTO.php");

class userAppService
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

    public function login($userDTO)
    {
        $IUserDAO = userFactory::CreateUser();

        $foundedUserDTO = $IUserDAO->login($userDTO);

        return $foundedUserDTO;
    }

    public function create($userDTO)
    {
        $IUserDAO = userFactory::CreateUser();

        $createdUserDTO = $IUserDAO->create($userDTO);

        return $createdUserDTO;
    }

}

?>