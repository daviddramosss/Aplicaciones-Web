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
            $stmt->bind_param("is", $recetaId, $etiqueta);

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
        // Implementar más adelante
    }
}

?>
