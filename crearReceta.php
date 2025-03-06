<?php

// Se incluyen los archivos de configuración y la clase del formulario para crear recetas.
require_once("includes/config.php");
require_once("includes/helpers/crearRecetaForm.php");

// Se define el título de la página.
$tituloPagina = 'Nueva Receta';

// Se instancia un objeto de la clase crearRecetaForm.
$form = new crearRecetaForm();

// Se genera el HTML del formulario llamando al método Manage().
$htmlFormReceta = $form->Manage();

// Se define el contenido principal de la página, incluyendo el formulario y una hoja de estilos CSS.
$contenidoPrincipal = <<<EOS
    <link rel="stylesheet" href="CSS/crearReceta.css">
   
    $htmlFormReceta
    
EOS;

// Se requiere la plantilla común para mostrar la página con el contenido generado.
require("includes/comun/plantilla.php");

?>
