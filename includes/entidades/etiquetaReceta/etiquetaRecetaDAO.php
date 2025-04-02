<?php

namespace es\ucm\fdi\aw\entidades\etiquetaReceta;


// require_once("IEtiquetaReceta.php"); 
// require_once("etiquetaRecetaDTO.php"); 
use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;
use es\ucm\fdi\aw\entidades\etiquetas\{etiquetasDTO};
// require_once(__DIR__ . "/../../comun/baseDAO.php"); 

/**
 * Clase que implementa la interfaz IEtiquetaReceta para gestionar etiquetas de recetas en la base de datos.
 * Extiende baseDAO para reutilizar funcionalidades comunes de acceso a datos.
 */
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

        // Asociar los parámetros a la consulta, especificando tipos ("i" para entero, "s" para string)
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

    // Método para editar una relación entre una receta y una etiqueta.
    public function editarEtiquetaReceta($etiquetaRecetaDTO)
    {
        // Implementar más adelante
    }

    // Método para borrar una relación entre una receta y una etiqueta.
    public function borrarEtiquetaReceta($recetaId)
    {

        // Obtener la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Obtener valores del DTO
        //$recetaId = $etiquetaRecetaDTO->getRecetaId();
        //$etiqueta = $etiquetaRecetaDTO->getEtiqueta();

        // Consulta SQL para eliminar la relación receta-etiqueta
        $query = "DELETE FROM receta_etiqueta WHERE Receta = ?";
        
        // Preparar la consulta
        $stmt = $conn->prepare($query);

        // Asociar los parámetros a la consulta
        $stmt->bind_param("i", $recetaId);

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            //throw new Exception("Error al eliminar la etiqueta: " . $stmt->error);
        }

        // Cerrar la declaración
        $stmt->close();
 
    }

    // Método para buscar una etiqueta de receta por su ID de receta.
    public function buscarEtiquetasReceta($recetaId)
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
        $stmt->bind_param("i", $recetaId);
    
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
    
        // Si no hay etiquetas o hay un error, retorna un array vacío
        return [];
    }        
    
}

?>
