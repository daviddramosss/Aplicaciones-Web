<?php

namespace es\ucm\fdi\aw\entidades\ingrediente;
// Definimos una interfaz llamada IIngrediente, que establece un contrato para la gestión de ingredientes
interface IIngrediente 
{
    // Método para crear un nuevo ingrediente, recibe un objeto DTO con la información del ingrediente
    public function crearIngrediente($ingredienteDTO);

    // Método para editar un ingrediente existente, recibe un objeto DTO con los datos actualizados
    public function editarIngrediente($ingredienteDTO);

    // Método para eliminar un ingrediente, recibe un objeto DTO con la identificación del ingrediente a eliminar
    public function eliminarIngrediente($ingredienteDTO);

}
?>
