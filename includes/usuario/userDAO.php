<?php

include_once __DIR__ . "/../config.php";
require_once("IUser.php");
require_once("userDTO.php");

class userDAO implements IUser
{
    public function __construct()
    {

    }

    public function login($userDTO)
    {
        $foundedUserDTO = $this->buscaUsuario($userDTO->email());
        
        if ($foundedUserDTO && $foundedUserDTO->password() === $userDTO->password()) 
        {
            return $foundedUserDTO;
        } 

        return false;
    }

    private function buscaUsuario($email)
    {
        $conn = getConexionBD();
        
        $query = sprintf("SELECT ID, Email, Password FROM usuarios WHERE Email='%s'", $conn->real_escape_string($email));
        
        $rs = $conn->query($query);
        
        if ($rs && $rs->num_rows == 1) 
        {
            $fila = $rs->fetch_assoc();
            
            $user = new userDTO($fila['ID'], $fila['Nombre'], $fila['Apellidos'], $fila['Email'], $fila['Rol'], $fila['Password'], $fila['DNI'], $fila['Cuenta_Bancaria']);

            $rs->free();

            return $user;
        }

        return false;
    }

    public function create($userDTO)
    {
        $createdUserDTO = false;

        $conn = getConexionBD();

        $nombreUsuario = $conn->real_escape_string($userDTO->name());
        $apellidosUsuario = $conn->real_escape_string($userDTO->apellidos());
        $emailUsuario = $conn->real_escape_string($userDTO->email());
        $passwordUsuario = $conn->real_escape_string($userDTO->password());
        $rolUsuario = $conn->real_escape_string($userDTO->rol());
        $dniUsuario = $conn->real_escape_string($userDTO->dni());
        $cuentaBancariaUsuario = $conn->real_escape_string($userDTO->cuentaBancaria());

        $query = sprintf("INSERT INTO usuarios(Nombre, Apellidos, Email, Rol, Password) VALUES ('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($userDTO->name())
            , $conn->real_escape_string($userDTO->apellidos())
            , $conn->real_escape_string($userDTO->email())
            , $conn->real_escape_string($userDTO->rol())
            , $conn->real_escape_string($userDTO->password()) 
            , $conn->real_escape_string($userDTO->dni())
            ,  $conn->real_escape_string($userDTO->cuentaBancaria())
        );

        if ( $conn->query($query) ) 
        {
            $idUser = $conn->insert_id;
            
            $createdUserDTO = new userDTO($idUser, $nombreUsuario, $apellidosUsuario, $emailUsuario, $rolUsuario, $passwordUsuario, $dniUsuario, $cuentaBancariaUsuario );
        } 

        return $createdUserDTO;
    }

}
?>