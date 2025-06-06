<?php

namespace es\ucm\fdi\aw\entidades\usuario;
//Interfaz de usuario
//Establece los metodos publicos (que usaran clases externas) que deben tener las instancias de usuarios
interface IUser
{
    public function login($userDTO);

    public function create($userDTO);

    public function buscaUsuario($userDTO);

    public function buscarUsuarioPorID($userDTO);

    public function editarPerfil($userDTO);
}
?>