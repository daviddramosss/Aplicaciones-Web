<?php

require_once("includes/helpers/noChefFormulario.php");      

// Se define el título de la página
$tituloPagina = 'estrellaMichelinNoChef';

// Crea una instancia de la clase contactoFormulario
$form = new noChefFormulario();

// Se genera el HTML del formulario llamando al método Manage()
$htmlFormCNoChef = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <!-- Se inserta el formulario generado dinámicamente por la clase noChefFormulario -->
    $htmlFormCNoChef

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");
?>
