<?php

namespace es\ucm\fdi\aw\entidades\receta;
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
    private $ruta;


    //Constructor de la clase recetaDTO
    public function __construct($id, $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fecha_creacion, $valoracion, $ruta)
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
        $this->ruta = $ruta;
    }

    // Métodos GET para obtener los valores de las propiedades
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPasos()
    {
        return $this->pasos;
    }

    public function getTiempo()
    {
        return $this->tiempo;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    public function getValoracion()
    {
        return $this->valoracion;
    }

    public function getRuta()
    {
        return $this->ruta;
    }
}

?>
