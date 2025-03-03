<?php

include __DIR__ . '/comun/formularioBase.php';

class indexForm extends formularioBase
{
    public function __construct() 
    {
        parent::__construct('indexForm');
    }

    protected function CreateFields($datos)
    {
        $html = <<<EOF
        <section class="destacadas">
            <h2>Top 10 recetas de hoy</h2>
            <div class="contenedor-flechas">
                <button id="prevReceta" class="boton-flecha">&lt;</button>
                <div id="recetaDestacada" class="contenido">
                    <!-- Aquí se mostrarán las recetas destacadas dinámicamente -->
                </div>
                <button id="nextReceta" class="boton-flecha">&gt;</button>
            </div>
        </section>

        <section class="ofertas"> 
            <h2>Ofertas</h2>
            <div class="contenedor-flechas">
                <button id="prevOferta" class="boton-flecha">&lt;</button>
                <div id="ofertaDestacada" class="contenido">
                    <!-- Aquí se mostrarán las ofertas dinámicamente -->
                </div>
                <button id="nextOferta" class="boton-flecha">&gt;</button>
            </div>
        </section>
 
        <script src="JS/index.js"></script>
        EOF;

        return $html;

    }

}

?>