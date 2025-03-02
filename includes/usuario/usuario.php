<?php

include __DIR__ . "/../config.php";
include("IUser.php");

class usuario implements IUser
{
    private $id;

    private $username;

    private $password;

    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function id()
    {
        return $this->id;
    }

    public function username()
    {
        return $this->username;
    }

    public function login($username, $password)
    {
        $user = $this->buscaUsuario($username);
        
        if ($user && $user->password === $password) 
        {
            return $user;
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
            
            $user = new usuario($fila['Id'], $fila['UserName'], $fila['Password']);
            
            $rs->free();

            return $user;
        }

        return false;
    }

    public function create($userName, $password)
    {
        $result = false;

        $conn = getConexionBD();

        $query = sprintf("INSERT INTO Usuarios(UserName, Password) VALUES ('%s', '%s')"
            , $conn->real_escape_string($userName)
            , $conn->real_escape_string($password)
        );

        if ( $conn->query($query) ) 
        {
            $idUser = $conn->insert_id;
            
            $result = new usuario($idUser, $userName, $password);
        } 

        return $result;
    }
}

?>