<?php

namespace es\ucm\fdi\aw\entidades\etiquetaReceta;
// require_once("IEtiquetaReceta.php"); 
// require_once("etiquetaRecetaDTO.php"); 
use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;
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

        try
        {
            // Obtener la conexión a la base de datos desde la instancia de la aplicación
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para insertar una nueva relación receta-etiqueta
            $query = "INSERT INTO receta_etiqueta (Receta, Etiqueta) VALUES (?, ?)";

            // Preparar la consulta
            $stmt = $conn->prepare($query);

            // Verificar si la consulta se preparó correctamente
            if (!$stmt)
            {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

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
        }
        catch(mysqli_sql_exception $e)
        {
            // Capturar y lanzar la excepción en caso de error SQL
            throw $e;
        }

        return $crearEtiquetaReceta; // Devolver false en caso de fallo
    }

    // Método para editar una relación entre una receta y una etiqueta.
    public function editarEtiquetaReceta($etiquetaRecetaDTO)
    {
        // Implementar más adelante
    }

    // Método para borrar una relación entre una receta y una etiqueta.
    public function borrarEtiquetaReceta($etiquetaRecetaDTO)
    {
        try 
        {
            // Obtener la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Obtener valores del DTO
            $recetaId = $etiquetaRecetaDTO->getRecetaId();
            $etiqueta = $etiquetaRecetaDTO->getEtiqueta();

            // Consulta SQL para eliminar la relación receta-etiqueta
            $query = "DELETE FROM receta_etiqueta WHERE Receta = ? AND Etiqueta = ?";
            
            // Preparar la consulta
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Asociar los parámetros a la consulta
            $stmt->bind_param("ii", $recetaId, $etiqueta);

            // Ejecutar la consulta
            if (!$stmt->execute()) {
                throw new Exception("Error al eliminar la etiqueta: " . $stmt->error);
            }

            // Cerrar la declaración
            $stmt->close();
        }
        catch (mysqli_sql_exception $e)
        {
            throw $e;
        }
    }

    // Método para buscar una etiqueta de receta por su ID de receta.
    public function buscarEtiquetasReceta($recetaId)
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();
    
        // Prepara la consulta SQL para obtener las etiquetas de la receta
        $query = "SELECT e.Nombre 
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
            // Declara la variable donde se almacenará el resultado
            $etiqueta = null;
    
            // Asocia la columna de la consulta con la variable PHP
            $stmt->bind_result($etiqueta);
    
            // Array donde se almacenarán las etiquetas
            $etiquetas = [];
    
            // Recorre los resultados y los guarda en el array
            while ($stmt->fetch()) 
            {
                $etiquetas[] = $etiqueta;
            }
    
            // Cierra la declaración
            $stmt->close();
    
            // Retorna el array con las etiquetas
            return $etiquetas;
        }
    
        // Si no hay etiquetas o hay un error, retorna un array vacío
        return [];
    }        
    
}

?>
