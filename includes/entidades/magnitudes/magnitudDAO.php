<?php

require_once("IMagnitud.php"); 
require_once("magnitudDTO.php"); 
require_once(__DIR__ . "/../../comun/baseDAO.php"); 

class magnitudesDAO extends baseDAO implements IMagnitud 
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

    public function mostarMagnitudes()
    {
        // Obtiene la conexión a la base de datos
        $conn = getConexionBd();

        // Prepara la consulta SQL para obtener todas las magnitudes
        $query = "SELECT * FROM magnitudes";

        // Ejecuta la consulta
        $result = $conn->query($query);

        // Array donde se almacenarán las magnitudes
        $magnitudes = [];

        // Si hay resultados, los recorremos
        if ($result && $result->num_rows > 0) 
        {
            while ($fila = $result->fetch_assoc()) 
            {
                // Crea un objeto etiquetaDTO con los datos obtenidos y lo añade al array
                $magnitudes[] = new etiquetaDTO($fila['id'], $fila['nombre']);
            }

            // Liberamos la memoria del resultado
            $result->free();
        }

        // Retorna el array con las magnitudes (puede estar vacío si no hay magnitudes en la BD)
        return $magnitudes;
    }

}


?>