<?php

class etiquetaRecetaDTO
{
    private $etiqueta;

    private $recetaId;

    public function __construct($recetaId, $etiqueta)
    {        
        $this->recetaId = $recetaId;
        $this->etiqueta = $etiqueta;
    }

    public function getEtiqueta()
    {
        return $this->etiqueta;
    }

    public function getRecetaId()
    {
        return $this->recetaId;
    }
    
}

?>