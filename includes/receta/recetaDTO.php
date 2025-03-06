<?php

/**
 * Clase recetaDTO (Data Transfer Object)
 * Representa una receta con sus atributos y métodos de acceso (getters).
 */
class recetaDTO
{
    // Propiedades privadas de la receta
    private $id;
    private $nombre;
    private $autor;
    private $descripcion;
    private $pasos;
    private $tiempo;
    private $precio;
    private $fecha_creacion;
    private $valoracion;

    /**
     * Constructor de la clase recetaDTO
     * 
     * @param int $id Identificador único de la receta.
     * @param string $nombre Nombre de la receta.
     * @param string $autor Autor/creador de la receta.
     * @param string $descripcion Descripción breve de la receta.
     * @param string $pasos Pasos de preparación en formato texto o array.
     * @param int $tiempo Tiempo estimado de preparación en minutos.
     * @param float $precio Precio estimado de los ingredientes.
     * @param string $fecha_creacion Fecha de creación de la receta.
     * @param float $valoracion Valoración promedio de la receta.
     */
    public function __construct($id, $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fecha_creacion, $valoracion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->autor = $autor;
        $this->descripcion = $descripcion;
        $this->pasos = $pasos;
        $this->tiempo = $tiempo;
        $this->precio = $precio;
        $this->fecha_creacion = $fecha_creacion;
        $this->valoracion = $valoracion;
    }

    // Métodos GET para obtener los valores de las propiedades

    /**
     * Obtiene el ID de la receta.
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Obtiene el nombre de la receta.
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Obtiene el autor de la receta.
     * @return string
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Obtiene la descripción de la receta.
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Obtiene los pasos de la receta.
     * @return string
     */
    public function getPasos()
    {
        return $this->pasos;
    }

    /**
     * Obtiene el tiempo estimado de preparación en minutos.
     * @return int
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Obtiene el precio estimado de los ingredientes.
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Obtiene la fecha de creación de la receta.
     * @return string
     */
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    /**
     * Obtiene la valoración promedio de la receta.
     * @return float
     */
    public function getValoracion()
    {
        return $this->valoracion;
    }
}

?>
