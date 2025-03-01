<?php

class IngredienteDTO 
{

    private $id;

    private $nombre;

    private $verificado:

    public function __construct($id, $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public function getId() 
    {
        return $this->id;
    }

    public function getNombre() 
    {
        return $this->nombre;
    }

    public function getVerificado()
    {
        return $this->verificado;
    }
}
?>
