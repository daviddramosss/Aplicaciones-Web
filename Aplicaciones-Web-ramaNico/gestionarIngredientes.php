<?php
require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\GestorIngredientes;

// Incluimos el CSS
echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';

// Creamos el gestor y procesamos posibles acciones (crear, editar, eliminar)
$gestor = new GestorIngredientes();
$gestor->procesarFormulario();

// Generamos el contenido y los parámetros para la plantilla
$contenidoPrincipal = $gestor->renderizar();
$tituloPagina = 'Gestionar Ingredientes';
$scripts = '<script src="js/gestiones.js" defer></script>';

// Cargamos la plantilla principal
require("includes/comun/plantilla.php");