<?php


interface IEtiquetas
{
    public function crearEtiqueta($etiquetaDTO);

    public function editarEtiqueta($etiquetaDTO);

    public function borrarEtiqueta($etiquetaDTO);

    public function mostrarEtiquetas();
}

?>