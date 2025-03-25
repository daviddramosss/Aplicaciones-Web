<?php

require_once("includes/config.php");
require_once("includes/vistas/EstrellaMichelinVista.php");
require_once("includes/modelos/Usuario.php");
require_once("includes/modelos/Receta.php");

// Se define el título de la página
$tituloPagina = 'Market Chef';

// Obtener el saldo del usuario (esto asume que hay una sesión iniciada)
$usuario = Usuario::obtenerUsuarioActual();
$saldo = $usuario ? $usuario->getSaldo() : 'No disponible';

// Obtener las recetas en venta
$recetasEnVenta = Receta::obtenerRecetasEnVenta();

// Generar el contenido principal utilizando la vista
$vista = new EstrellaMichelinVista();
$contenidoPrincipal = $vista->render($saldo, $recetasEnVenta);

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
