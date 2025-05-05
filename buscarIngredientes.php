<?php
require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\GestorIngredientes;

if (isset($_GET['term'])) {
    $term = $_GET['term'];
    $gestor = new GestorIngredientes();
    $ingredientes = $gestor->buscarIngredientesPorNombre('%' . $term . '%');
    echo json_encode($ingredientes);
} else {
    echo json_encode([]);
}
?>
