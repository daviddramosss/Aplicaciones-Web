<?php

require_once("includes/config.php");

require_once("includes/helpers/loginForm.php");

$tituloPagina = 'Inicio de sesión';

$form = new loginForm(); 

$htmlFormLogin = $form->Manage();

$contenidoPrincipal = <<<EOS
<h1>Login de usuario</h1>
$htmlFormLogin
EOS;

require("includes/comun/plantilla.php");
?>