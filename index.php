<?php

require_once("includes/config.php");
use es\ucm\fdi\aw\helpers\indexHelper;

// Se define el título de la página
$tituloPagina = 'Market Chef';

// Crea una instancia de la clase IndexHelper
$indexHelper = new indexHelper();
$htmlIndex = $indexHelper->getRecetas();

// Define el contenido principal de la página
$contenidoPrincipal = <<<EOS
    $htmlIndex
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
