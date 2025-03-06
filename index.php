<?php

// Se incluye el archivo de configuración general del proyecto 
require_once("includes/config.php");

// Se define el título de la página que se mostrará en el navegador
$tituloPagina = 'Market Chef';

// Se genera el contenido principal de la página mediante una cadena heredoc
$contenidoPrincipal = <<<EOS

    <!-- Se incluye el archivo CSS específico para la página de inicio -->
    <link rel="stylesheet" href="CSS/index.css">
    
    <!-- Título principal de la página -->
    <h1> Market Chef </h1>

    <!-- Sección para las recetas destacadas -->
    <section class="destacadas">
        <h2>Top 10 recetas de hoy</h2>
        
        <!-- Contenedor para las flechas de navegación y la receta destacada -->
        <div class="contenedor-flechas">
            <!-- Botón para navegar a la receta anterior -->
            <button id="prevReceta" type="button" class="boton-flecha">&lt;</button>
            
            <!-- Sección donde se mostrarán las recetas destacadas dinámicamente -->
            <div id="recetaDestacada" class="contenido">
                <!-- Aquí se mostrarán las recetas destacadas que se actualizarán dinámicamente con JavaScript -->
            </div>
            
            <!-- Botón para navegar a la siguiente receta -->
            <button id="nextReceta" type="button" class="boton-flecha">&gt;</button>
        </div>
    </section>

    <!-- Sección para las ofertas -->
    <section class="ofertas"> 
        <h2>Ofertas</h2>
        
        <!-- Contenedor para las flechas de navegación y las ofertas -->
        <div class="contenedor-flechas">
            <!-- Botón para navegar a la oferta anterior -->
            <button id="prevOferta" type="button" class="boton-flecha">&lt;</button>
            
            <!-- Sección donde se mostrarán las ofertas dinámicamente -->
            <div id="ofertaDestacada" class="contenido">
                <!-- Aquí se mostrarán las ofertas que se actualizarán dinámicamente con JavaScript -->
            </div>
            
            <!-- Botón para navegar a la siguiente oferta -->
            <button id="nextOferta" type="button" class="boton-flecha">&gt;</button>
        </div>
    </section>

    <!-- Se incluye el archivo JavaScript específico para manejar las interacciones en la página de inicio -->
    <script src="JS/index.js"></script>

EOS;

// Se incluye el archivo plantilla.php 
require("includes/comun/plantilla.php");

?>
