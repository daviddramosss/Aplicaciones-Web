<?php

namespace es\ucm\fdi\aw\entidades\plato;

interface IPlato
{
    // Asegúrate de que el tipo del parámetro sea el mismo en ambos lugares
    public function crearPlato(PlatoDTO $platoDTO);
    public function editarPlato(PlatoDTO $platoDTO);
    public function eliminarPlato(PlatoDTO $platoDTO);
    public function obtenerPlatos(): array;
    public function obtenerIngredientesDePlato($idPlato): array;
    public function asociarIngrediente($idPlato, $idIngrediente);
    public function desasociarIngrediente($idPlato, $idIngrediente);
}

?>
