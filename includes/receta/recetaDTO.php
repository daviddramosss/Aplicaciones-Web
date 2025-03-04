<?php

class recetaDTO
{
    private $id;

    private $nombre;

    private $autor;

    private $descripcion;

    private $pasos;

    private $tiempo;

    private $precio;

    private $fecha_creacion;

    private $valoracion;

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

    public function getFecha_Creacion()
    {
        return $this->fecha_creacion;
    }

    public function getValoracion()
    {
        return $this->valoracion;
    }

}
?>