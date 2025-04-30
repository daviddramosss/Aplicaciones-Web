<?php

namespace es\ucm\fdi\aw\entidades\recetaComprada;
use es\ucm\fdi\aw\entidades\receta\{recetaDTO};

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

        $recetas = []; // Guardará las recetas encontradas

        // Prepara la consulta SQL para buscar las recetas compradas por el usuario
        $query = "
            SELECT r.ID, r.Nombre, r.Ruta 
            FROM receta_comprada rc
            JOIN recetas r ON rc.Receta = r.ID
            WHERE rc.Usuario = ?
        ";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el ID del comprador
        $comprador = $userDTO->getId();
        $stmt->bind_param("i", $comprador);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Obtiene el resultado de la consulta
            $result = $stmt->get_result();

            // Si hay resultados, los recorremos
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Guardamos la info de la receta comprada
                    $recetas[] = new recetaDTO(
                        $row["ID"],      // ID de la receta
                        $row["Nombre"],  // Nombre de la receta
                        null,            // Otros parámetros que puedes necesitar
                        null,
                        null,
                        null,
                        null,
                        null,
                        $row["Ruta"]     // Ruta de la receta
                    );
                }
            }
        }

        // Cierra la declaración
        $stmt->close();

        return $recetas;
    }
}  
?>