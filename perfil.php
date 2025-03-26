<?php

require_once("includes/config.php");
require_once("includes/helpers/perfilHelper.php");

$tituloPagina = 'Mi perfil';

$perfilHelper = new perfilHelper();
$contenidoPrincipal = $perfilHelper->generarPerfil();

require("includes/comun/plantilla.php");

?>