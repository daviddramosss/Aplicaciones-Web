<?php
interface IIngrediente 
{
    public function crearIngrediente($ingredienteDTO);

    public function editarIngrediente($ingredienteDTO);

    public function eliminarIngrediente($ingredienteDTO);

    public function obtenerIngredientes();
}
?>
