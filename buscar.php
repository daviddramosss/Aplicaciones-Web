<?php

require_once("includes/config.php");   

use es\ucm\fdi\aw\helpers\buscarHelper; //para instanciar clases                     

// Se define el título de la página
$tituloPagina = 'Buscar Recetas';

// Crea una instancia de la clase buscarFormulario
$helper = new buscarHelper();
$htmlBuscarHelper = $helper->print();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    $htmlBuscarHelper
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
