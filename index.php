<?php

require_once("includes/config.php");
require_once("includes/indexForm.php");

$tituloPagina = 'Market Chef';

$form = new indexForm();
$htmlFormIndex = $form->Manage(); 

$contenidoPrincipal = <<<EOS
    <link rel="stylesheet" href="CSS/index.css">
    <h1> Market Chef </h1>

    $htmlFormIndex

EOS;


require("includes/comun/plantilla.php");
?>