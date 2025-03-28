<?php
require_once("includes/config.php");
use es\ucm\fdi\aw\helpers\editarRecetaForm;

// Se define el título de la página.
$tituloPagina = 'Editar Receta';

// Se instancia un objeto de la clase crearRecetaForm.
$form = new editarRecetaForm();

// Se genera el HTML del formulario llamando al método Manage().
$htmlFormModReceta = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    $htmlFormModReceta
    
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");


?> 