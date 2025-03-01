<?php

require_once("includes/config.php");
require_once("includes/crearReceta/crearRecetaForm.php");


$tituloPagina = 'Nueva Receta';

$form = new crearRecetaForm();
$htmlFormReceta = $form->Manage();

$contenidoPrincipal = <<<EOS
    <link rel="stylesheet" href="CSS/crearReceta.css">
    <h1>Crear Nueva Receta</h1>
    
    $htmlFormReceta
    
EOS;

require("includes/comun/plantilla.php");
?>
