<?php

namespace es\ucm\fdi\aw\entidades\magnitudes;
require_once("../../config.php");
use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;
// require_once("IMagnitud.php"); 
// require_once("magnitudDTO.php"); 
// require_once(__DIR__ . "/../../comun/baseDAO.php"); 

class magnitudDAO extends baseDAO implements IMagnitud 
{
    public function __construct()
    {
    }

    public function crearMagnitud($etiquetaDTO)
    {
        //Implementar luego
    }

    public function editarMagnitud($etiquetaDTO)
    {
        //Implementar luego
    }

    public function borrarMagnitud($etiquetaDTO)
    {
        //Implementar luego
    }

    public function mostrarMagnitudes()
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para obtener todas las magnitudes
        $query = "SELECT ID, Nombre FROM magnitudes";

        // Se prepara la consulta
        $stmt = $conn->prepare($query);
        $stmt->execute();

        // Array donde se almacenarán las magnitudes
        $magnitudes = [];

        $result = $stmt->get_result();
        // Si hay resultados, los recorremos
        if ($result->num_rows > 0) 
        {
            while ($fila = $result->fetch_assoc()) 
            {
                // Crea un objeto magnitudDTO con los datos obtenidos y lo añade al array
                $magnitudes[] = [
                    "id" => $fila['ID'], 
                    "nombre" => $fila['Nombre']
                ];
            }

            $stmt->close();
            // Liberamos la memoria del resultado
            $result->free();
        }
        // Retorna el array con las magnitudes (puede estar vacío si no hay magnitudes en la BD)
        return $magnitudes;
    }

}


?>