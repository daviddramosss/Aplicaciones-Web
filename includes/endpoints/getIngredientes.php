<?php


//Necesario para que carge el JavaScript
require_once("../config.php");
use es\ucm\fdi\aw\{application};

    // Se obtiene la conexión a la base de datos a través de la aplicación
    $conn = application::getInstance()->getConexionBd();

    // Consulta SQL para obtener los ingredientes
    $query = "SELECT id, Nombre FROM ingredientes"; // Asegurar que 'id' también se obtiene

    // Se prepara la consulta
    $stmt = $conn->prepare($query);
    
    if($stmt->execute())
    {
        $ingredientes = [];

        // Se obtiene el resultado de la consulta
        $result = $stmt->get_result();
        if ($result->num_rows > 0)   
        {
            // Se recorren los resultados y se almacenan en un array
            while ($row = $result->fetch_assoc())
            {
                // No lo pasasos como un DTO, debido a que se llama desde JavaScript y es mas fácil usar un array
                $ingredientes[] = [
                    "id" => $row['id'],
                    "nombre" => $row['Nombre']
                ];
            }
        }
    }

    // Se cierra la consulta preparada
    $stmt->close();       

    // Especificamos que la respuesta será en formato JSON
    header('Content-Type: application/json');

    // Convertimos el array de ingredientes a formato JSON y lo enviamos como respuesta
    echo json_encode($ingredientes);
?>
