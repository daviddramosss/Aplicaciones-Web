<?php

interface IReceta
{
   public function crearReceta($recetaDTO);

   public function editarReceta($recetaDTO);

   public function borrarReceta($recetaDTO);
}
?>