<?php

require_once("includes/config.php");
require_once("includes/helpers/iniciarPagoHelper.php");

$tituloPagina = 'Procesando pago';

$helper = new iniciarPagoHelper();
$contenidoPrincipal = $helper->procesar();

require("includes/comun/plantilla.php");

?>