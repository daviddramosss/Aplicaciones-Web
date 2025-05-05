<?php

require_once("../../config.php");
use es\ucm\fdi\aw\entidades\plato\PlatoAppService;

// Obtenemos una instancia única (Singleton) del servicio de platos
$platoService = PlatoAppService::GetSingleton();

// Llamamos al método para obtener la lista de platos desde la base de datos
$platos = $platoService->obtenerPlatos();

// Especificamos que la respuesta será en formato JSON
header('Content-Type: application/json');

// Convertimos el array de platos a formato JSON y lo enviamos como respuesta
echo json_encode($platos);

?>
