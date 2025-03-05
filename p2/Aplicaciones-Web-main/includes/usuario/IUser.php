<?php

interface IUser
{
    public function login($userDTO);

    public function create($userDTO);

    public function buscaUsuario($email);
}
?>