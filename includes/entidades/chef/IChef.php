<?php

namespace es\ucm\fdi\aw\entidades\chef;

interface IChef 
{

    public function crearChef($chefDTO);

    public function editarChef($chefDTO);

    public function borrarChef($chefDTO);

    public function informacionChef($userDTO);

}
?>