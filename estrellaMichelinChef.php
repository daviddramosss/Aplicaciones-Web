<?php

require_once("includes/config.php");
        
// Se define el título de la página
$tituloPagina = 'Market Chef';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS

    <!-- Enlace a la hoja de estilos para la página de Estrella Michelin -->
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/estrellaMichelin.css">

    <!-- Título principal de la página -->
    <h1> Estrella Michelin </h1>

    <!-- Sección para mostrar el saldo del usuario -->
    <h2> Saldo: ...............</h2>
    
    <!-- Botón para crear una nueva receta -->
    <div class="crear-receta-container">
        <a href="crearReceta.php" class="boton-crear" id="botonCrearReceta">Crear Receta</a>
    </div>

    <!-- Sección donde se mostrarán las recetas en venta -->
    <section class="En venta"> 
        <h2>Recetas en venta</h2>
        <div class="contenedor-flechas">
            <!-- Botón para ver la receta anterior -->
            <button id="prevOferta" type="button" class="boton-flecha">&lt;</button>

            <!-- Contenedor donde se cargarán dinámicamente las recetas en venta -->
            <div id="ofertaDestacada" class="contenido">
                <!-- Aquí se mostrarán las recetas en venta dinámicamente -->
            </div>

            <!-- Botón para ver la siguiente receta -->
            <button id="nextOferta" type="button" class="boton-flecha">&gt;</button>
        </div>
    </section>

    <!-- Inclusión del archivo JavaScript que maneja la interacción con las recetas en venta -->
    <script src="JS/estrellaMichelinChef.js"></script>

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
