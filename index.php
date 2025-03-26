<?php

require_once("includes/config.php");
require_once("includes/helpers/IndexHelper.php");

// Se define el título de la página
$tituloPagina = 'Market Chef';

// Crea una instancia de la clase IndexHelper
$indexHelper = new IndexHelper();

// Genera el HTML de las secciones dinámicas llamando a los métodos de IndexHelper
$htmlRecetasDestacadas = $indexHelper->getRecetasDestacadas();
$htmlOfertas = $indexHelper->getOfertas();
$htmlRecetasVeganas = $indexHelper->getRecetasVeganas();

// Define el contenido principal de la página
$contenidoPrincipal = <<<EOS

    <!-- Se incluye el archivo CSS específico para la página de inicio -->
    <link rel="stylesheet" href="CSS/index.css">
    
    <!-- Título principal de la página -->
    <h1> Market Chef </h1>

    <!-- Sección para las recetas destacadas generada dinámicamente -->
    $htmlRecetasDestacadas

    <!-- Sección para las ofertas generada dinámicamente -->
    $htmlOfertas

    <!-- Sección para recetas veganas generada dinámicamente -->
    $htmlRecetasVeganas

    <!-- Se incluye el archivo JavaScript específico para manejar las interacciones en la página de inicio -->
    <script src="JS/index.js"></script>

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
