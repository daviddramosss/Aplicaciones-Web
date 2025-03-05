<?php

class etiquetaRecetaDTO
{
    private $etiquetaId;

    private $recetaId;

    public function __construct($etiquetaId, $recetaId)
    {
        $this->etiquetaId = $etiquetaId;
        $this->recetaId = $recetaId;
    }

    public function getEtiquetaId()
    {
        return $this->etiquetaId;
    }

    public function getRecetaId()
    {
        return $this->recetaId;
    }
    
}

?>