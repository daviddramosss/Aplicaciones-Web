<?php


require_once("includes/config.php");                        
require_once("includes/helpers/buscarFormulario.php");      

// Se define el título de la página
$tituloPagina = 'Buscar Recetas';

// Crea una instancia de la clase buscarFormulario
$form = new buscarFormulario();

// Genera el HTML del formulario llamando al método Manage(), que devuelve un formulario listo para ser mostrado
$htmlFormBuscar = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <!-- Enlace a la hoja de estilos específica para la página de búsqueda -->
    <link rel="stylesheet" href="CSS/buscar.css">
    
    <!-- Enlace al script JavaScript que maneja la interacción en la búsqueda -->
    <script src="JS/buscar.js" defer></script>
    
    <!-- Título de la página -->
    <h1>Buscar Recetas</h1>

    <!-- Formulario de búsqueda generado dinámicamente -->
    $htmlFormBuscar

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
