<?php

namespace es\ucm\fdi\aw\entidades\chef;

class chefDTO
{
    private $id;
    private $DNI;
    private $Cuenta_Bancaria;
    private $Saldo;

    public function __construct($id, $DNI, $Cuenta_Bancaria, $Saldo)
    {
        $this->id = $id;
        $this->DNI = $DNI;
        $this->Cuenta_Bancaria = $Cuenta_Bancaria;
        $this->Saldo = $Saldo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDNI()
    {
        return $this->DNI;
    }   

    public function getCuenta_Bancaria()
    {
        return $this->Cuenta_Bancaria;  
    }

    public function getSaldo()
    {
        return $this->Saldo;
    }

}


?>