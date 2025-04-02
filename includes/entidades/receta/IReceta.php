<?php

namespace es\ucm\fdi\aw\entidades\receta;

interface IReceta
{

   public function buscarReceta($recetaId);

   public function crearReceta($recetaDTO);

   public function editarReceta($recetaDTO);

   public function borrarReceta($recetaId);

   public function mostarRecetasPorAutor($userDTO);

   public function mostrarRecetas($crtierio);

   public function busquedaDinamica($buscarPlato, $ordenar, $precioMin, $precioMax, $valoracion, $etiquetas);
    
}

?>
