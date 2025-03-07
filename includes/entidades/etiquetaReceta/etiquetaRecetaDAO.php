<?php

require_once("IEtiquetaReceta.php"); // Interfaz que define las operaciones sobre etiquetas de recetas
require_once("etiquetaRecetaDTO.php"); // Objeto de transferencia de datos (DTO) para etiquetas de recetas
require_once(__DIR__ . "/../../comun/baseDAO.php"); // Clase base para acceso a datos

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

    /**
     * Método para crear una nueva relación entre una receta y una etiqueta en la base de datos.
     * @param etiquetaRecetaDTO $etiquetaRecetaDTO Objeto DTO con los datos de la relación receta-etiqueta.
     * @return etiquetaRecetaDTO|bool Devuelve un objeto etiquetaRecetaDTO con los datos insertados o false si falla.
     * @throws Exception Si hay un error en la preparación o ejecución de la consulta.
     */
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

    /**
     * Método para editar una relación entre una receta y una etiqueta.
     * (Pendiente de implementación)
     */
    public function editarEtiquetaReceta($etiquetaRecetaDTO)
    {
        // Implementar más adelante
    }

    /**
     * Método para borrar una relación entre una receta y una etiqueta.
     * (Pendiente de implementación)
     */
    public function borrarEtiquetaReceta($etiquetaRecetaDTO)
    {
        // Implementar más adelante
    }
}

?>
