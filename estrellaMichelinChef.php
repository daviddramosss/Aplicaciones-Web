<?php

// Se incluye el archivo de configuración, que probablemente establece conexión con la base de datos y carga configuraciones globales
require_once("includes/config.php");

// Define el título de la página
$tituloPagina = 'Market Chef';

// Se utiliza la sintaxis de heredoc (<<<EOS) para almacenar el contenido HTML principal en una variable PHP
$contenidoPrincipal = <<<EOS

    <!-- Enlace a la hoja de estilos para la página de Estrella Michelin -->
    <link rel="stylesheet" href="CSS/index.css">

    <!-- Título principal de la página -->
    <h1> Estrella Michelin </h1>

    <!-- Sección para mostrar el saldo del usuario -->
    <h2> Saldo: ...............</h2>
    
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

// Se incluye la plantilla general de la página, que probablemente contiene la estructura base del sitio web
require("includes/comun/plantilla.php");

?>
