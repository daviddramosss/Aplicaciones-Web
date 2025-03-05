<?php
require_once("../config.php");
require("ingredienteAppService.php");

// Obtenemos la lista de ingredientes desde la base de datos
$ingredienteService = IngredienteAppService::GetSingleton();

$ingredientes = $ingredienteService->obtenerIngredientes();

// Devolvemos la respuesta en formato JSON
header('Content-Type: application/json');

echo json_encode($ingredientes);

?>
