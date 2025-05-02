<?php

namespace es\ucm\fdi\aw\entidades\receta;

interface IReceta
{

   public function buscarReceta($recetaDTO);

   public function crearReceta($recetaDTO);

   public function editarReceta($recetaDTO);

   public function borrarReceta($recetaDTO);

   public function mostarRecetasPorAutor($userDTO);

   public function mostrarRecetas($crtierio);
   
   public function buscarRecetasConEtiquetas($etiquetas, $idRecetaActual);

   public function esAutor($idAutor, $idRecetaActual);
}

?>
