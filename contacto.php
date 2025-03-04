<?php
require_once("includes/contacto/contactoFormulario.php");

$tituloPagina = 'Contacto';
$form = new contactoFormulario();
$htmlFormContacto = $form->Manage();

$contenidoPrincipal = <<<EOS
    

    $htmlFormContacto

EOS;

require("includes/comun/plantilla.php");
?>