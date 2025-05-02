<?php

namespace es\ucm\fdi\aw\entidades\recetaComprada;

interface IRecetaComprada
{
    public function mostarRecetasPorComprador($userDTO);

    public function comprarReceta($recetaCompradaDTO);

}

?>
