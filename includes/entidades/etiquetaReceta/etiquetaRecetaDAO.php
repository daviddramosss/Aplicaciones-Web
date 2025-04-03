<?php

namespace es\ucm\fdi\aw\entidades\etiquetaReceta;

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;
use es\ucm\fdi\aw\entidades\etiquetas\{etiquetasDTO};

class etiquetaRecetaDAO extends baseDAO implements IEtiquetaReceta
{
    // Constructor vacio
    public function __construct()
    {
    }

    // Método para crear una nueva relación entre una receta y una etiqueta en la base de datos.
    public function crearEtiquetaReceta($etiquetaRecetaDTO)
    {
        $crearEtiquetaReceta = false; // Variable de retorno inicializada en false

        // Obtener la conexión a la base de datos desde la instancia de la aplicación
        $conn = application::getInstance()->getConexionBd();

        // Consulta SQL para insertar una nueva relación receta-etiqueta
        $query = "INSERT INTO receta_etiqueta (Receta, Etiqueta) VALUES (?, ?)";

        // Preparar la consulta
        $stmt = $conn->prepare($query);

        // Obtener valores del DTO
        $recetaId = $etiquetaRecetaDTO->getRecetaId();
        $etiqueta = $etiquetaRecetaDTO->getEtiqueta();

        // Asociar los parámetros a la consulta, especificando tipos
        $stmt->bind_param("ii", $recetaId, $etiqueta);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute())
        {
            // Si la inserción fue exitosa, devolver un nuevo DTO con los datos insertados
            $crearEtiquetaReceta = new etiquetaRecetaDTO($recetaId, $etiqueta);
            return $crearEtiquetaReceta;
        }

        return $crearEtiquetaReceta; // Devolver false en caso de fallo
    }

    // Método para borrar una relación entre una receta y una etiqueta.
    public function borrarEtiquetaReceta($recetaDTO)
    {
        $borrado = false;

        // Obtener la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Consulta SQL para eliminar la relación receta-etiqueta
        $query = "DELETE FROM receta_etiqueta WHERE Receta = ?";
        
        // Preparar la consulta
        $stmt = $conn->prepare($query);

        // Asociar los parámetros a la consulta
        $stmt->bind_param("i", $recetaDTO->getId());

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $borrado = true;
        }

        // Cerrar la declaración
        $stmt->close();

        return $borrado;
 
    }

    // Método para buscar una etiqueta de receta por su ID de receta.
    public function buscarEtiquetasReceta($recetaDTO)
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();
    
        // Prepara la consulta SQL para obtener las etiquetas de la receta
        $query = "SELECT e.Nombre, e.ID
                    FROM etiquetas e
                    JOIN receta_etiqueta re ON e.ID = re.Etiqueta
                    WHERE re.Receta = ?";
    
        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);
    
        // Asocia el parámetro de la consulta con el valor del ID de la receta
        $id = $recetaDTO->getId();
        $stmt->bind_param("i", $id);
    
        // Ejecuta la consulta
        if ($stmt->execute()) 
        {
            $result = $stmt->get_result();
            $etiqueta = [];
    
            // Si hay resultados, los recorremos y creamos DTOs de recetas
            if ($result->num_rows > 0) 
            {
                while ($row = $result->fetch_assoc()) 
                {
                    $etiqueta[] = new etiquetasDTO(
                        $row["ID"],
                        $row["Nombre"]
                    );
                }
            }
            // Cierra la declaración
            $stmt->close();
    
            // Retorna el array con las etiquetas
            return $etiqueta;
        }
    }        
    
}

?>
