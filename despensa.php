<?php

require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\despensaFormulario;    

// Se define el título de la página
$tituloPagina = 'Mi despensa';

// Crea una nueva instancia de la clase despensaFormulario
$form = new despensaFormulario();
$htmlFormDespensa = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    $htmlFormDespensa
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");
?>
