<?php
// Incluye el archivo que contiene la clase 'contactoFormulario' que gestiona el formulario de contacto
require_once("includes/helpers/noChefFormulario.php");

// Establece el título de la página
$tituloPagina = 'estrellaMichelinNoChef';

// Crea una instancia de la clase contactoFormulario
$form = new noChefFormulario();

// Llama al método 'Manage()' de la clase contactoFormulario para generar el HTML del formulario de contacto
$htmlFormCNoChef = $form->Manage();

// Genera el contenido principal de la página, que incluirá el formulario de contacto
$contenidoPrincipal = <<<EOS
    <!-- Se inserta el formulario generado dinámicamente por la clase noChefFormulario -->
    $htmlFormCNoChef
EOS;

// Incluye la plantilla principal del sitio, donde se integrará el contenido generado
require("includes/comun/plantilla.php");
?>
