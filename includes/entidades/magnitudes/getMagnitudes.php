<?php

//Necesario para que carge el JavaScript
require_once("../../config.php");

use es\ucm\fdi\aw\entidades\magnitudes\MagnitudAppService;

// Obtenemos una instancia única (Singleton) del servicio de magnitudes
$magnitudService = MagnitudAppService::GetSingleton();

// Llamamos al método para obtener la lista de magnitudes desde la base de datos
$magnitudes = $magnitudService->mostrarMagnitudes();

// Especificamos que la respuesta será en formato JSON
header('Content-Type: application/json');

// Convertimos el array de magnitudes a formato JSON y lo enviamos como respuesta
echo json_encode($magnitudes);

?>
