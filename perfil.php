<?php

require_once("includes/config.php");
use es\ucm\fdi\aw\helpers\perfilHelper;

$tituloPagina = 'Mi perfil';

$perfilHelper = new perfilHelper();
$contenidoPrincipal = $perfilHelper->generarPerfil();

require("includes/comun/plantilla.php");

?>