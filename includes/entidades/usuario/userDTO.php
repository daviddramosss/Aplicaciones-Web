<?php

//userDTO permite crear instancias de usuarios que NO se conectan directamente a la BBDD
//Permiten agrupar datos en instancias de usuario para enviarlo a funciones como parámetros por ejemplo
class userDTO
{
    //Contiene todos los atributos de un usuario, tal cual aparencen en la tabla Usuarios en nuestra BBDD (MarketChef)
    private $id;

    private $nombre;

    private $apellidos;

    private $email;

    private $rol;

    private $password;

    private $DNI;

    private $cuentaBancaria;

    public function __construct($id, $nombre, $apellidos, $email, $rol, $password, $DNI, $cuentaBancaria)
    {
        //Asigna los parametros a los atributos del usuario
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->rol = $rol;
        $this->password = $password;
        $this->DNI = $DNI;
        $this->cuentaBancaria = $cuentaBancaria;
    }
    

    //Getters de cada atributo para emplearlo en otras clases
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getDNI()
    {
        return $this->DNI;
    }

    public function getCuentaBancaria()
    {
        return $this->cuentaBancaria;
    }
    
}
?>