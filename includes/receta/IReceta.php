<?php

interface IReceta
{
   public function crearReceta($recetaDTO, $ingredientes, $etiquetas);

   public function editarReceta($recetaDTO);

   public function borrarReceta($recetaDTO);
}
?>