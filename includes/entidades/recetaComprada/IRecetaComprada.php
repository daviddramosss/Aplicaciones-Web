<?php

namespace es\ucm\fdi\aw\entidades\recetaComprada;

interface IRecetaComprada
{
    public function mostrarRecetasPorComprador($recetaCompradaDTO);

    public function comprarReceta($recetaCompradaDTO);

    public function esComprador($recetaCompradaDTO);
}

?>
