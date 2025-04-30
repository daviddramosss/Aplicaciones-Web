<?php

require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\iniciarPagoHelper;

$tituloPagina = 'Procesando pago';

$helper = new iniciarPagoHelper();
$contenidoPrincipal = $helper->generarFormularioPago();

require("includes/comun/plantilla.php");

?>