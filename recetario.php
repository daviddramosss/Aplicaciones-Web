<?php

require_once("includes/config.php");

// Se define el título de la página
$tituloPagina = 'Market Chef';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <!-- Enlace a la hoja de estilos específica para esta página -->
    <link rel="stylesheet" href="CSS/recetario.css">
    
    <h1> Mi recetario </h1>

    <!-- Sección que muestra las recetas compradas -->
    <section class="compradas">
        <h2>Recetas compradas</h2>
        <div class="contenedor-flechas">
            <!-- Botón para navegar a la receta anterior -->
            <button id="prevReceta" type="button" class="boton-flecha">&lt;</button>
            <div id="recetaDestacada" class="contenido">
                <!-- Aquí se mostrarán dinámicamente las recetas compradas -->
            </div>
            <!-- Botón para navegar a la siguiente receta -->
            <button id="nextReceta" type="button" class="boton-flecha">&gt;</button>
        </div>
    </section>

    <!-- Sección que muestra la lista de deseos (wishlist) -->
    <section class="ofertas"> 
        <h2>Wishlist</h2>
        <div class="contenedor-flechas">
            <!-- Botón para navegar a la oferta anterior -->
            <button id="prevOferta" type="button" class="boton-flecha">&lt;</button>
            <div id="ofertaDestacada" class="contenido">
                <!-- Aquí se mostrarán dinámicamente las recetas favoritas -->
            </div>
            <!-- Botón para navegar a la siguiente oferta -->
            <button id="nextOferta" type="button" class="boton-flecha">&gt;</button>
        </div>
    </section>

    <!-- Inclusión del archivo JavaScript que maneja la lógica de navegación y actualización de contenido -->
    <script src="JS/recetario.js"></script>

EOS;

/// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
