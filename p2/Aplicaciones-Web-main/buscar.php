<?php
require_once("includes/config.php");
require_once("includes/buscar/buscarFormulario.php");

$tituloPagina = 'Buscar Recetas';

$form = new buscarFormulario();
$htmlFormBuscar = $form->Manage();


$contenidoPrincipal = <<<EOS
    <link rel="stylesheet" href="CSS/buscar.css">
    <script src="JS/buscar.js" defer></script>
     <h1>Buscar Recetas</h1>

     $htmlFormBuscar

EOS;

require("includes/comun/plantilla.php");
?>