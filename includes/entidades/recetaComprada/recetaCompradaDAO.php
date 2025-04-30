<?php

namespace es\ucm\fdi\aw\entidades\recetaComprada;

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;

// La clase recetaDAO hereda de baseDAO e implementa la interfaz IReceta
class recetaCompradaDAO extends baseDAO implements IRecetaComprada
{
    // Constructor vacío
    public function __construct()
    {
    }

    public function mostarRecetasPorComprador($userDTO)
    {
        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        $recetas = []; //Guardará las recetas encontradas; Se coloca aqui para evitar errores cuando no encuentre nada.

        // Prepara la consulta 1 SQL para buscar el id de las recetas compradas
        $query = "SELECT Receta FROM receta_comprada WHERE Usuario = ?";

        // Prepara la declaración 1 SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el ID del comprador
        $comprador = $userDTO->getId();
        $stmt->bind_param("i", $comprador);

        // Ejecuta la consulta 1
        if($stmt->execute())
        {
            // Obtiene el resultado de la consulta 1, devolviendo los IDs de las recetas compradas
            $result = $stmt->get_result();
            $recetas_ID = [];

            // Si hay resultados, los recorremos
            if ($result->num_rows > 0) 
            {
                $i = 0; //Contador de IDs
                while ($row = $result->fetch_assoc()) 
                {  
                    $recetas_ID[]= $row["Receta"]; //Guardamos los IDs de recetas compradas
                    // Prepara la consulta 2 SQL para buscar la info de la receta iesima comprada
                    $query2 = "SELECT Nombre, Ruta FROM Recetas WHERE ID = ?";

                    // Prepara la declaración 2 SQL
                    $stmt2 = $conn->prepare($query2);

                    // Asocia el parámetro de la consulta con el ID de la receta
                    $stmt2->bind_param("i", $recetas_ID[$i]);

                     // Ejecuta la consulta 2
                    if($stmt2->execute())
                    {
                        // Obtiene el resultado de la consulta 2
                        $result2 = $stmt2->get_result();
                            while($row2 = $result2->fetch_assoc()){ //Guardamos la info de la receta iesima
                                $recetas[] = new recetaDTO(
                                    $recetas_ID[$i],
                                    $row2["Nombre"],
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    $row2["Ruta"]
                                );
                            }
                    }
                    $i++; //Aumentamos el contador
                }
            }
        }

        // Cierra la declaración
        // Usamos solo close, debido a que: Cierra el statement y libera todos los recursos asociados, por lo que usar un free sería innecesario.
        $stmt->close();

        return $recetas;
    }
}  
?>