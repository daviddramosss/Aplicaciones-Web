<?php

require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\loginForm;

// Se define el título de la página
$tituloPagina = 'Inicio de sesión';

$form = new loginForm(); 

$htmlFormLogin = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    $htmlFormLogin

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");
?>