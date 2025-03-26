<?php

use es\ucm\fdi\aw\helpers\buscarFormulario; //para instanciar clases

require_once("includes/config.php");                        

// Se define el título de la página
$tituloPagina = 'Buscar Recetas';

// Crea una instancia de la clase buscarFormulario
$form = new buscarFormulario();

// Genera el HTML del formulario llamando al método Manage(), que devuelve un formulario listo para ser mostrado
$htmlFormBuscar = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <!-- Formulario de búsqueda generado dinámicamente -->
    $htmlFormBuscar

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
