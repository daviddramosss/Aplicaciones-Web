<?php

require_once("includes/config.php");
use es\ucm\fdi\aw\helpers\crearRecetaForm;
// require_once("includes/helpers/crearRecetaForm.php");

// Se define el título de la página.
$tituloPagina = 'Nueva Receta';

// Se instancia un objeto de la clase crearRecetaForm.
$form = new crearRecetaForm();

// Se genera el HTML del formulario llamando al método Manage().
$htmlFormReceta = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
       
    $htmlFormReceta
    
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
