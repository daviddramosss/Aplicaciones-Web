<?php

include_once __DIR__ . "/../config.php";
require("IUser.php");
require("userDTO.php");

class userDAO implements IUser
{
    public function __construct()
    {

    }

    public function login($userDTO)
    {
        $foundedUserDTO = $this->buscaUsuario($userDTO->username());
        
        if ($foundedUserDTO && $foundedUserDTO->password() === $userDTO->password()) 
        {
            return $foundedUserDTO;
        } 

        return false;
    }

    private function buscaUsuario($username)
    {
        $conn = getConexionBD();
        
        $query = sprintf("SELECT Id, UserName, Password FROM Usuarios WHERE username='%s'", $conn->real_escape_string($username));
        
        $rs = $conn->query($query);
        
        if ($rs && $rs->num_rows == 1) 
        {
            $fila = $rs->fetch_assoc();
            
            $user = new userDTO($fila['Id'], $fila['UserName'], $fila['Password']);
            
            $rs->free();

            return $user;
        }

        return false;
    }

    public function create($userDTO)
    {
        $createdUserDTO = false;

        $conn = getConexionBD();

        $query = sprintf("INSERT INTO Usuarios(UserName, Password) VALUES ('%s', '%s')"
            , $conn->real_escape_string($userDTO->userName())
            , $conn->real_escape_string($userDTO->password())
        );

        if ( $conn->query($query) ) 
        {
            $idUser = $conn->insert_id;
            
            $createdUserDTO = new userDTO($idUser, $userName, $password);
        } 

        return $createdUserDTO;
    }

}
?>