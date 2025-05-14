<?php

require_once("includes/config.php");
use es\ucm\fdi\aw\helpers\confirmarPagoHelper;

// Título de la página
$tituloPagina = 'Pago realizado con éxito';

// Procesa la confirmación
$helper = new confirmarPagoHelper();
$contenidoPrincipal = $helper->procesar();

// Carga la plantilla
require("includes/comun/plantilla.php");
