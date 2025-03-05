<?php
session_start();

include("includes/helpers/registerForm.php");

$tituloPagina = 'Registro en el sistema';

$form = new registerForm(); 

$htmlFormRegistro = $form->Manage();

$contenidoPrincipal = <<<EOS
<h1>Registro de usuario</h1>
<div>
    <img src="img/LogoRegistro.png" alt="LogoRegistro" style="width: 150px; height: auto;">
</div>
$htmlFormRegistro
EOS;

require("includes/comun/plantilla.php");
?>