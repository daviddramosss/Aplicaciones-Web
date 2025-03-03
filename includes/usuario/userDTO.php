<?php

class userDTO
{
    private $id;

    private $name;

    private $apellidos;

    private $email;

    private $rol;

    private $password;

    private $DNI;

    private $cuentaBancaria;

    public function __construct($id, $name, $apellidos, $email, $rol, $password, $DNI, $cuentaBancaria)
    {
        $this->id = $id;
        $this->name = $name;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->rol = $rol;
        $this->password = $password;
        $this->DNI = $DNI;
        $this->cuentaBancaria = $cuentaBancaria;
    }
    

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function apellidos()
    {
        return $this->apellidos;
    }

    public function email()
    {
        return $this->email;
    }

    public function rol()
    {
        return $this->rol;
    }

    public function password()
    {
        return $this->password;
    }

    public function DNI()
    {
        return $this->DNI;
    }

    public function cuentaBancaria()
    {
        return $this->cuentaBancaria;
    }
    
}
?>