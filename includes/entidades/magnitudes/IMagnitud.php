<?php

namespace es\ucm\fdi\aw\entidades\magnitudes;

interface IMagnitud
{
    public function crearMagnitud($etiquetaDTO);

    public function editarMagnitud($etiquetaDTO);

    public function borrarMagnitud($etiquetaDTO);

}

?>