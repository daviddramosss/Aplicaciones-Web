<?php
// Habilitar depuración temporalmente
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\GestorIngredientes;

header('Content-Type: application/json');

try {
    if (isset($_GET['q'])) {
        $busqueda = trim($_GET['q']);
        $gestor = new GestorIngredientes();
        $ingredientes = $gestor->buscarIngredientes($busqueda);
        echo json_encode(array_values($ingredientes));
    } else {
        echo json_encode([]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}