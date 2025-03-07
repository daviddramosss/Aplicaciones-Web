<?php

require_once("includes/config.php");                        
require_once("includes/helpers/despensaFormulario.php");   

// Se define el título de la página
$tituloPagina = 'Mi despensa';

// Crea una nueva instancia de la clase despensaFormulario
$form = new despensaFormulario();

// Se genera el HTML del formulario llamando al método Manage()
$htmlFormDespensa = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <!-- Enlace al archivo CSS específico para el formulario de la despensa -->
    <link rel="stylesheet" href="CSS/despensa.css">

    <!-- Enlace al archivo JavaScript que maneja interacciones relacionadas con la despensa -->
    <script src="JS/despensa.js"></script>

    <!-- Inserta el formulario generado dinámicamente por la clase 'despensaFormulario' -->
    $htmlFormDespensa
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");
?>
