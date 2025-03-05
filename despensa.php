<?php
require_once("includes/config.php");
require_once("includes/helpers/despensaFormulario.php");

$tituloPagina = 'Mi despensa';

$form = new despensaFormulario();
$htmlFormDespensa = $form->Manage();

$contenidoPrincipal = <<<EOS
    <link rel="stylesheet" href="CSS/despensa.css">
    <script src="JS/despensa.js"></script>
    

    $htmlFormDespensa

EOS;

require("includes/comun/plantilla.php");
?>