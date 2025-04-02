<?php

//Necesario para que carge el JavaScript
require_once("../../config.php");

use es\ucm\fdi\aw\entidades\etiquetas\EtiquetasAppService;

// Obtenemos una instancia única (Singleton) del servicio de etiquetas
$etiquetasService = EtiquetasAppService::GetSingleton();

// Llamamos al método para obtener la lista de etiquetas desde la base de datos
$etiquetas = $etiquetasService->mostrarEtiquetas();

// Especificamos que la respuesta será en formato JSON
header('Content-Type: application/json');

// Convertimos el array de etiquetas a formato JSON y lo enviamos como respuesta
echo json_encode($etiquetas);

?>