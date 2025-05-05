<?php
require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\GestorIngredientes;

echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';
echo '<script src="JS/gestiones.js"></script>';

$gestor = new GestorIngredientes();
$gestor->procesarFormulario();

$contenidoPrincipal = $gestor->renderizar();

$tituloPagina = 'Gestionar Ingredientes';
require("includes/comun/plantilla.php");
