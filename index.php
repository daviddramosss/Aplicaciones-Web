<?php

require_once("includes/config.php");
use es\ucm\fdi\aw\helpers\IndexHelper;
// require_once("includes/helpers/IndexHelper.php");

// Se define el título de la página
$tituloPagina = 'Market Chef';

// Crea una instancia de la clase IndexHelper
$indexHelper = new IndexHelper();
$htmlIndex = $indexHelper->getRecetas();


// Define el contenido principal de la página
$contenidoPrincipal = <<<EOS

    $htmlIndex

    <!-- Se incluye el archivo JavaScript específico para manejar las interacciones en la página de inicio -->
    <script src="JS/index.js"></script>

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
