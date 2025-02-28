<?php

interface IReceta
{
   public function create($recetaDTO);

   public function edit($recetaDTO);

   public function delete($recetaDTO);
}
?>