<?php

namespace es\ucm\fdi\aw\entidades\receta;
// Interfaz IReceta que define los métodos básicos que cualquier clase que implemente esta interfaz debe tener
interface IReceta
{
   // Método para crear una nueva receta
   // Recibe un objeto recetaDTO (que contiene la información de la receta) y los ingredientes y etiquetas asociados
   public function crearReceta($recetaDTO, $ingredientes, $etiquetas);

   // Método para editar una receta existente
   // Recibe un objeto recetaDTO que contiene la nueva información de la receta a actualizar
   public function editarReceta($recetaDTO);

   // Método para borrar una receta
   // Recibe un objeto recetaDTO que representa la receta a eliminar
   public function borrarReceta($recetaDTO);

   public function mostarRecetasPorAutor($userDTO);
}

?>
