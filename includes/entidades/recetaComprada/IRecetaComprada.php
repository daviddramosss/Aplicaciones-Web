<?php

namespace es\ucm\fdi\aw\entidades\recetaComprada;

interface IRecetaComprada
{
    public function mostarRecetasPorComprador($recetaCompradaDTO);

    public function comprarReceta($recetaCompradaDTO);

    public function esComprador($recetaCompradaDTO);
}

?>
