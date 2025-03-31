<?php

require_once("includes/config.php");
use es\ucm\fdi\aw\helpers\mostrarRecetaHelper;

// Se define el título de la página.
$tituloPagina = 'Receta';

// Obtener el ID de la receta desde la URL
$recetaId = $_GET['id'] ?? null;

if (!$recetaId) {
    die("Error: No se especificó una receta válida.");
}    

// Se instancia un objeto de la clase mostrarRecetaHelper.
$mostrarRecetaHelper = new mostrarRecetaHelper($recetaId);

$htmlMostrarReceta = $mostrarRecetaHelper->print();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    $htmlMostrarReceta
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>