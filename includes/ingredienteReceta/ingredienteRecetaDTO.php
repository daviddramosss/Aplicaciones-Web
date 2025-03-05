<?php

    class ingredienteRecetaDTO
    {
        private $recetaId;

        private $ingredienteId;

        private $cantidad;

        private $magnitud;

        public function __construct($recetaId, $ingredienteId, $cantidad, $magnitud)
        {
            $this->recetaId = $recetaId;
            $this->ingredienteId = $ingredienteId;
            $this->cantidad = $cantidad;
            $this->magnitud = $magnitud;
        }

        public function getRecetaId()
        {
            return $this->recetaId;
        }

        public function gerIngredienteId()
        {
            return $this->ingredienteId;
        }

        public function getCantidad()
        {
            return $this->cantidad;
        }

        public function getMagnitud()
        {
            return $this->magnitud;
        }
    }

?>