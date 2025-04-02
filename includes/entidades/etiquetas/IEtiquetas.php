<?php

namespace es\ucm\fdi\aw\entidades\etiquetas;

interface IEtiquetas
{
    public function crearEtiqueta($etiquetaDTO);

    public function editarEtiqueta($etiquetaDTO);

    public function borrarEtiqueta($etiquetaDTO);
}

?>