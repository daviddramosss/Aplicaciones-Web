<?php

require_once("includes/config.php");   

use es\ucm\fdi\aw\helpers\buscarFormulario; //para instanciar clases                     

// Se define el título de la página
$tituloPagina = 'Buscar Recetas';

// Crea una instancia de la clase buscarFormulario
$form = new buscarFormulario();
$htmlBuscarFormulario = $form->manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    $htmlBuscarFormulario
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
