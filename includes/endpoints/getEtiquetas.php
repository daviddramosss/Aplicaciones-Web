<?php

//Necesario para que carge el JavaScript
require_once("../config.php");

use es\ucm\fdi\aw\{application};

 // Accede a la base de datos
 $conn = application::getInstance()->getConexionBd();

 // Prepara la consulta SQL para obtener todas las etiquetas
 $query = "SELECT ID, Nombre FROM etiquetas";

 // Ejecuta la consulta
 $stmt = $conn->prepare($query);
 
 if($stmt->execute())
 {
     // Array donde se almacenarán las etiquetas
     $etiquetas = [];

     $result = $stmt->get_result();
     // Si hay resultados, los recorremos
     if ($result->num_rows > 0) 
     {
         while ($fila = $result->fetch_assoc()) 
         {
             // No lo pasasos como un DTO, debido a que se llama desde JavaScript y es mas fácil usar un array
             $etiquetas[] = [
                 "id" => $fila['ID'], 
                 "nombre" => $fila['Nombre']
             ];
         }
     }
 }
 
 $stmt->close();

// Especificamos que la respuesta será en formato JSON
header('Content-Type: application/json');

// Convertimos el array de etiquetas a formato JSON y lo enviamos como respuesta
echo json_encode($etiquetas);

?>