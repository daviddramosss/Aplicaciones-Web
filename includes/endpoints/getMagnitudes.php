<?php

//Necesario para que carge el JavaScript
require_once("../config.php");

use es\ucm\fdi\aw\{application};   

// Accede a la base de datos
$conn = application::getInstance()->getConexionBd();

// Prepara la consulta SQL para obtener todas las magnitudes
$query = "SELECT ID, Nombre FROM magnitudes";

// Se prepara la consulta
$stmt = $conn->prepare($query);

if($stmt->execute())
{
    // Array donde se almacenarán las magnitudes
    $magnitudes = [];

    $result = $stmt->get_result();
    // Si hay resultados, los recorremos
    if ($result->num_rows > 0) 
    {
        while ($fila = $result->fetch_assoc()) 
        {
            // No lo pasasos como un DTO, debido a que se llama desde JavaScript y es mas fácil usar un array
            $magnitudes[] = [
                "id" => $fila['ID'], 
                "nombre" => $fila['Nombre']
            ];
        }
    }
}

// Cierra la declaración
// Usamos solo close, debido a que: Cierra el statement y libera todos los recursos asociados, por lo que usar un free sería innecesario.
$stmt->close();

// Especificamos que la respuesta será en formato JSON
header('Content-Type: application/json');

// Convertimos el array de magnitudes a formato JSON y lo enviamos como respuesta
echo json_encode($magnitudes);

?>
