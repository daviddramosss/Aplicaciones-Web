<?php
require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\GestorIngredientes;

// Cargar estilos y scripts
echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';
echo '<script src="JS/gestiones.js"></script>';

// Crear instancia del helper y procesar formulario
$gestor = new GestorIngredientes();
$gestor->procesarFormulario();

// Obtener HTML generado por el gestor
$contenidoPrincipal = $gestor->generarVista();

$tituloPagina = 'Gestionar Ingredientes';

require("includes/comun/plantilla.php");
?>
