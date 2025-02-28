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

    private function getId()
    {
        return $this->id;
    }

    private function getNombre()
    {
        return $this->nombre;
    }

    private function getAutor()
    {
        return $this->autor;
    }

    private function getDescripcion()
    {
        return $this->descripcion;
    }

    private function getPasos()
    {
        return $this->pasos;
    }

    private function getTiempo()
    {
        return $this->tiempo;
    }

    private function getPrecio()
    {
        return $this->precio;
    }

    private function getFecha_Creacion()
    {
        return $this->fecha_creacion;
    }

    private function getValoracion()
    {
        return $this->valoracion;
    }

}
?>