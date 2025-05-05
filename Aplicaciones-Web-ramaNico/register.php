<?php
session_start();

use es\ucm\fdi\aw\helpers\registerForm;
// include("includes/helpers/registerForm.php");

// Se define el título de la página
$tituloPagina = 'Registro en el sistema';

$form = new registerForm(); 

$htmlFormRegistro = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    $htmlFormRegistro

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");
?>