<?php

require_once("includes/config.php");

$tituloPagina = 'Market Chef';

$contenidoPrincipal = <<<EOS

    <link rel="stylesheet" href="CSS/index.css">
    <h1> Estrella Michelin </h1>

       <h2> Saldo: ...............</h2>
    
   

        <section class="En venta"> 
            <h2>Recetas en venta</h2>
            <div class="contenedor-flechas">
                <button id="prevOferta" type="button" class="boton-flecha">&lt;</button>
                <div id="ofertaDestacada" class="contenido">
                    <!-- Aquí se mostrarán las recestas favoritas dinámicamente -->
                </div>
                <button id="nextOferta" type="button" class="boton-flecha">&gt;</button>
            </div>
        </section>
 
    <script src="JS/estrellaMichelinChef.js"></script>

EOS;


require("includes/comun/plantilla.php");

?>