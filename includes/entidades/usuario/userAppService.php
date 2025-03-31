<?php

namespace es\ucm\fdi\aw\entidades\usuario;

// Clase intermedia mediante la cual podemos acceder a las operaciones relacionadas con los usuarios
class userAppService
{
    // Declaramos los atributos que tendrá la clase
    private static $instance;

    //  Función que devuleve la Singleton de la clase
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

    // Función mediante la cual accedemos a donde está la lógica del login y obtenemos el usuario de la base de datos
    public function login($userDTO)
    {
        $IUserDAO = userFactory::CreateUser();

        $foundedUserDTO = $IUserDAO->login($userDTO);

        return $foundedUserDTO;
    }

    // función mediante la cual accedemos a las funciones que crean al usuario en la base de datos y devolvemos el usuario creado
    public function create($userDTO)
    {
        $IUserDAO = userFactory::CreateUser();

        $createdUserDTO = $IUserDAO->create($userDTO);

        return $createdUserDTO;
    }

    // función mediante la cual accedemos a la lógica detrás de la función que busca al usuario en la base de datos por su email
    public function buscarUsuario($email)
    {
        $IUserDAO = userFactory::CreateUser();
        $foundedUserDTO = $IUserDAO->buscaUsuario($email);
        if($foundedUserDTO){
            return $foundedUserDTO;
        }
        return false;
    }

    public function buscarUsuarioPorID($userId){
        $IUserDAO = userFactory::CreateUser();
        return $IUserDAO->buscarUsuarioPorID($userId);
    }
   
}

?>