<?php

require_once("includes/config.php");

require_once("includes/helpers/loginForm.php");

// Se define el título de la página
$tituloPagina = 'Inicio de sesión';

$form = new loginForm(); 

$htmlFormLogin = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <h1>Inicio de sesión</h1>
    $htmlFormLogin

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");
?>