<?php

/**
 * Interfaz IEtiquetaReceta
 * Define los métodos que deben implementar las clases encargadas de gestionar la relación entre recetas y etiquetas en la base de datos.
 */
interface IEtiquetaReceta
{
    /**
     * Crea una nueva relación entre una receta y una etiqueta.
     * @param etiquetaRecetaDTO $etiquetaRecetaDTO Objeto que contiene los datos de la relación.
     * @return etiquetaRecetaDTO|bool Devuelve un objeto con la relación creada o false si falla.
     */
    public function crearEtiquetaReceta($etiquetaRecetaDTO);

    /**
     * Edita una relación existente entre una receta y una etiqueta.
     * @param etiquetaRecetaDTO $etiquetaRecetaDTO Objeto con los datos actualizados de la relación.
     * @return etiquetaRecetaDTO|bool Devuelve el objeto actualizado o false si falla.
     */
    public function editarEtiquetaReceta($etiquetaRecetaDTO);

    /**
     * Borra una relación entre una receta y una etiqueta.
     * @param etiquetaRecetaDTO $etiquetaRecetaDTO Objeto con los datos de la relación a eliminar.
     * @return bool Devuelve true si la eliminación fue exitosa, false en caso contrario.
     */
    public function borrarEtiquetaReceta($etiquetaRecetaDTO);
}

?>
