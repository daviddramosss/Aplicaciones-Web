<?php

require_once("../../config.php");
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteAppService;
// require_once("ingredienteAppService.php");

// Obtenemos una instancia única (Singleton) del servicio de ingredientes
$ingredienteService = IngredienteAppService::GetSingleton();

// Llamamos al método para obtener la lista de ingredientes desde la base de datos
$ingredientes = $ingredienteService->obtenerIngredientes();

// Especificamos que la respuesta será en formato JSON
header('Content-Type: application/json');

// Convertimos el array de ingredientes a formato JSON y lo enviamos como respuesta
echo json_encode($ingredientes);

?>
