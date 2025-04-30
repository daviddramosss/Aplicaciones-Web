<?php

require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\carritoHelper;

$tituloPagina = 'Carrito de compras';

// Creamos instancia del helper y generamos el HTML del carrito
$helper = new carritoHelper();
$contenidoPrincipal = $helper->generarHTML();

// Usamos la plantilla común del sitio
require("includes/comun/plantilla.php");

?>