<?php
// Incluye el archivo de configuración general del proyecto
require_once("includes/config.php");

// Incluye el archivo que contiene la clase 'despensaFormulario' que maneja la lógica del formulario para la página de despensa
require_once("includes/helpers/despensaFormulario.php");

// Establece el título de la página
$tituloPagina = 'Mi despensa';

// Crea una nueva instancia de la clase 'despensaFormulario' para manejar el formulario relacionado con la despensa
$form = new despensaFormulario();

// Llama al método 'Manage()' de la clase 'despensaFormulario' para generar el HTML del formulario de despensa
$htmlFormDespensa = $form->Manage();

// Genera el contenido principal de la página, que incluye el formulario de la despensa
$contenidoPrincipal = <<<EOS
    <!-- Enlace al archivo CSS específico para el formulario de la despensa -->
    <link rel="stylesheet" href="CSS/despensa.css">

    <!-- Enlace al archivo JavaScript que maneja interacciones relacionadas con la despensa -->
    <script src="JS/despensa.js"></script>

    <!-- Inserta el formulario generado dinámicamente por la clase 'despensaFormulario' -->
    $htmlFormDespensa
EOS;

// Incluye la plantilla principal del sitio, donde se integrará el contenido generado para la página
require("includes/comun/plantilla.php");
?>
