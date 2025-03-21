<?php

interface IMagnitud
{
    public function crearMagnitud($etiquetaDTO);

    public function editarMagnitud($etiquetaDTO);

    public function borrarMagnitud($etiquetaDTO);

    public function mostarMagnitudes();
}

?>