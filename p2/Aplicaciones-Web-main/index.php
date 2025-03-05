<?php

require_once("includes/config.php");

$tituloPagina = 'Market Chef';

$contenidoPrincipal = <<<EOS

    <link rel="stylesheet" href="CSS/index.css">
    <h1> Market Chef </h1>

    <section class="destacadas">
            <h2>Top 10 recetas de hoy</h2>
            <div class="contenedor-flechas">
                <button id="prevReceta" type="button" class="boton-flecha">&lt;</button>
                <div id="recetaDestacada" class="contenido">
                    <!-- Aquí se mostrarán las recetas destacadas dinámicamente -->
                </div>
                <button id="nextReceta" type="button" class="boton-flecha">&gt;</button>
            </div>
        </section>

        <section class="ofertas"> 
            <h2>Ofertas</h2>
            <div class="contenedor-flechas">
                <button id="prevOferta" type="button" class="boton-flecha">&lt;</button>
                <div id="ofertaDestacada" class="contenido">
                    <!-- Aquí se mostrarán las ofertas dinámicamente -->
                </div>
                <button id="nextOferta" type="button" class="boton-flecha">&gt;</button>
            </div>
        </section>
 
        <script src="JS/index.js"></script>

EOS;


require("includes/comun/plantilla.php");

?>