<?php


interface IEtiqueta
{
    public function crearEtiqueta($etiquetaDTO);

    public function editarEtiqueta($etiquetaDTO);

    public function borrarEtiqueta($etiquetaDTO);

    public function mostarEtiquetas();
}

?>