<?php

namespace es\ucm\fdi\aw\entidades\recetaComprada;
/**
 * Clase recetaDTO (Data Transfer Object)
 * Representa una receta con sus atributos y métodos de acceso (getters).
 */
class recetaCompradaDTO
{
    // Propiedades privadas de la receta
    private $usuario;
    private $receta;


    //Constructor de la clase recetaDTO
    public function __construct($usuario, $receta){
        $this->usuario = $usuario;
        $this->receta = $receta;
       
    }

    // Métodos GET para obtener los valores de las propiedades
    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getReceta()
    {
        return $this->receta;
    }

}

?>
