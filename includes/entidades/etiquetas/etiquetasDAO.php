<?php

namespace es\ucm\fdi\aw\entidades\etiquetas;
// require_once("IEtiquetas.php"); 
// require_once("etiquetasDTO.php"); 
use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;
// require_once(__DIR__ . "/../../comun/baseDAO.php"); 

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

    public function mostrarEtiquetas()
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para obtener todas las etiquetas
        $query = "SELECT ID, Nombre FROM etiquetas";

        // Ejecuta la consulta
        $stmt = $conn->prepare($query);
        $stmt->execute();

        // Array donde se almacenarán las etiquetas
        $etiquetas = [];

        $result = $stmt->get_result();
        // Si hay resultados, los recorremos
        if ($result->num_rows > 0) 
        {
            while ($fila = $result->fetch_assoc()) 
            {
                // Crea un objeto etiquetaDTO con los datos obtenidos y lo añade al array
                $etiquetas[] = [
                    "id" => $fila['ID'], 
                    "nombre" => $fila['Nombre']
                ];
            }

            $stmt->close();
            // Liberamos la memoria del resultado
            $result->free();
        }


        // Retorna el array con las etiquetas (puede estar vacío si no hay etiquetas en la BD)
        return $etiquetas;
    }

}


?>