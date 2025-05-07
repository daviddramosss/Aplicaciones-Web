<?php

namespace es\ucm\fdi\aw\entidades\receta;

interface IReceta
{

   public function buscarReceta($recetaDTO);

   public function crearReceta($recetaDTO);

   public function editarReceta($recetaDTO);

   public function borrarReceta($recetaDTO);

   public function mostrarRecetasPorAutor($userDTO);
   
   public function mostrarRecetas($crtierio);
   
   public function buscarRecetasConEtiquetas($etiquetas, $recetaDTO);

   public function esAutor($recetaDTO);
}

?>
