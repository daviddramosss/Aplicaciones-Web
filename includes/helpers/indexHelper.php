<?php

class IndexHelper {
    public function getRecetasDestacadas() {
        return <<<HTML
        <section class="destacadas">
            <h2>Top 10 recetas de hoy</h2>
            <div class="contenedor-flechas">
                <button id="prevReceta" type="button" class="boton-flecha">&lt;</button>
                <div id="recetaDestacada" class="contenido"></div>
                <button id="nextReceta" type="button" class="boton-flecha">&gt;</button>
            </div>
        </section>
        HTML;
    }

    public function getOfertas() {
        return <<<HTML
        <section class="ofertas"> 
            <h2>Ofertas</h2>
            <div class="contenedor-flechas">
                <button id="prevOferta" type="button" class="boton-flecha">&lt;</button>
                <div id="ofertaDestacada" class="contenido"></div>
                <button id="nextOferta" type="button" class="boton-flecha">&gt;</button>
            </div>
        </section>
        HTML;
    }

    public function getRecetasVeganas() {
        return <<<HTML
        <section class="veganas"> 
            <h2>Recetas Veganas</h2>
            <div class="contenedor-flechas">
                <button id="prevVegana" type="button" class="boton-flecha">&lt;</button>
                <div id="recetaVegana" class="contenido"></div>
                <button id="nextVegana" type="button" class="boton-flecha">&gt;</button>
            </div>
        </section>
        HTML;
    }
}

?>
