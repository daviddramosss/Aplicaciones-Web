<?php

interface IEtiquetaReceta
{
    public function crearEtiquetaReceta($etiquetaRecetaDTO);

    public function editarEtiquetaReceta($etiquetaRecetaDTO);

    public function borrarEtiquetaReceta($etiquetaRecetaDTO);
}

?>