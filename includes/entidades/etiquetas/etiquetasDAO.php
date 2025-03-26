<?php

require_once("IEtiquetas.php"); 
require_once("etiquetasDTO.php"); 
require_once(__DIR__ . "/../../comun/baseDAO.php"); 

class etiquetasDAO extends baseDAO implements IEtiquetas 
{
    public function __construct()
    {
    }

    public function crearEtiqueta($etiquetaDTO)
    {
        //Implementar luego
    }

    public function editarEtiqueta($etiquetaDTO)
    {
        //Implementar luego
    }

    public function borrarEtiqueta($etiquetaDTO)
    {
        //Implementar luego
    }

    public function mostarEtiquetas()
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para obtener todas las etiquetas
        $query = "SELECT * FROM etiquetas";

        // Ejecuta la consulta
        $result = $conn->query($query);

        // Array donde se almacenarán las etiquetas
        $etiquetas = [];

        // Si hay resultados, los recorremos
        if ($result && $result->num_rows > 0) 
        {
            while ($fila = $result->fetch_assoc()) 
            {
                // Crea un objeto etiquetaDTO con los datos obtenidos y lo añade al array
                $etiquetas[] = new etiquetaDTO($fila['id'], $fila['nombre']);
            }

            // Liberamos la memoria del resultado
            $result->free();
        }

        // Retorna el array con las etiquetas (puede estar vacío si no hay etiquetas en la BD)
        return $etiquetas;
    }

}


?>