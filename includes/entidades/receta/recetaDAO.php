<?php

require_once("IReceta.php");
require_once("recetaDTO.php");
require_once(__DIR__ . "/../../comun/baseDAO.php");
require_once("recetaAlreadyExistException.php");

include __DIR__ . '/../ingredienteReceta/ingredienteRecetaAppService.php';
include __DIR__ . '/../etiquetaReceta/etiquetaRecetaAppService.php';

// La clase recetaDAO hereda de baseDAO e implementa la interfaz IReceta
class recetaDAO extends baseDAO implements IReceta
{
    // Constructor vacío
    public function __construct()
    {

    }

    // Función privada para buscar una receta en la base de datos por su ID
    private function buscarReceta($recetaId)
    {
        // Escapa el ID de la receta para evitar inyección SQL
        $escRecetaId = $this->realEscapeString($recetaId);

        // Obtiene la conexión a la base de datos usando el patrón Singleton
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para buscar la receta
        $query = "SELECT * FROM recetas WHERE recetaId = ?";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el valor del ID
        $stmt->bind_param("i", $escRecetaId);

        // Ejecuta la consulta
        $stmt->execute();

        // Declara las variables donde se almacenarán los resultados
        $Id = $Nombre = $Autor = $Descripcion = $Pasos = $Tiempo = $Precio = $Fecha_Creacion = $Valoracion = null;

        // Asocia las columnas de la consulta con las variables PHP
        $stmt->bind_result($Id, $Nombre, $Autor, $Descripcion, $Pasos, $Tiempo, $Precio, $Fecha_Creacion, $Valoracion);

        // Si se encontró la receta
        if ($stmt->fetch())
        {
            // Crea un objeto recetaDTO con los datos obtenidos
            $receta = new recetaDTO($Id, $Nombre, $Autor, $Descripcion, $Pasos, $Tiempo, $Precio, $Fecha_Creacion, $Valoracion);

            // Cierra la declaración
            $stmt->close();

            // Retorna el objeto receta
            return $receta;
        }

        // Si no se encuentra la receta, retorna false
        return false;
    }

    // Función pública para crear una receta en la base de datos
    public function crearReceta($recetaDTO, $ingredientes, $etiquetas)
    {
        $createdRecetaDTO = false;

        try
        {
            // Obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Prepara la consulta SQL para insertar una receta
            $query = "INSERT INTO recetas (Nombre, Autor, Descripcion, Pasos, Tiempo, Precio, Fecha_Creacion, Valoracion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepara la declaración SQL
            $stmt = $conn->prepare($query);

            // Si no se puede preparar la consulta, lanza una excepción
            if (!$stmt)
            {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Obtiene los valores del DTO de receta y los limpia para evitar inyección SQL
            $nombre = $recetaDTO->getNombre();
            $autor = $recetaDTO->getAutor();
            $descripcion = $recetaDTO->getDescripcion();
            $pasos = json_encode($recetaDTO->getPasos()); // Convierte los pasos en JSON
            $tiempo = $recetaDTO->getTiempo();
            $precio = $recetaDTO->getPrecio();
            $fechaCreacion = $recetaDTO->getFechaCreacion(); 
            $valoracion = $recetaDTO->getValoracion();

            // Asocia los parámetros de la consulta con los valores obtenidos
            $stmt->bind_param("sissidsd", $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion);

            // Si la consulta se ejecuta correctamente
            if ($stmt->execute())
            {
                // Obtiene el ID de la receta insertada
                $id = $conn->insert_id;

                // Crea un DTO de receta con los datos insertados
                $createdRecetaDTO = new recetaDTO($id, $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion);

                // Guarda los ingredientes relacionados con la receta
                $ingredienteRecetaService = ingredienteRecetaAppService::GetSingleton();

                foreach ($ingredientes as $ingredienteId => $ingredienteData) {
                    $ingredienteId = intval($ingredienteId);
                    $cantidad = floatval($ingredienteData['cantidad'] ?? 0);
                    $magnitud = filter_var($ingredienteData['magnitud'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
                    // Si el ingrediente es válido, lo guarda
                    if ($ingredienteId > 0 && $cantidad > 0 && !empty($magnitud)) {
                        $ingredienteRecetaDTO = new ingredienteRecetaDTO($id, $ingredienteId, $cantidad, $magnitud);
                        $ingredienteRecetaService->crearIngredienteReceta($ingredienteRecetaDTO);
                    }
                }

                // Guarda las etiquetas relacionadas con la receta
                $etiquetaRecetaService = etiquetaRecetaAppService::GetSingleton();

                $etiquetas = array_slice(array_unique($etiquetas), 0, 3); // Limita a 3 etiquetas únicas
                foreach ($etiquetas as $etiqueta) {
                    $etiqueta = filter_var($etiqueta, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    // Si la etiqueta es válida, la guarda
                    if (!empty($etiqueta)) {
                        $etiquetaRecetaDTO = new etiquetaRecetaDTO($id, $etiqueta);
                        $etiquetaRecetaCreadaDTO = $etiquetaRecetaService->crearEtiquetaReceta($etiquetaRecetaDTO);
                    }
                }           

                // Retorna el DTO de la receta creada
                return $createdRecetaDTO;
            }
        }
        catch(mysqli_sql_exception $e)
        {
            // Si se detecta un error de clave duplicada (receta ya existe)
            if ($conn->sqlstate == 23000) 
            { 
                throw new recetaAlreadyExistException("Ha ocurrido un error al crear la receta '{$recetaDTO->recetaName()}'");
            }
            
            // Lanza cualquier otro tipo de excepción
            throw $e;
        }

        // Retorna false si algo sale mal
        return $createdRecetaDTO;
    }

    // Función pública para editar una receta existente
    public function editarReceta($recetaDTO)
    {
        $editedRecetaDTO = false;

        try
        {
            // Obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Prepara la consulta SQL para actualizar la receta
            $query = "UPDATE recetas SET Nombre = ?, Autor = ?, Descripcion = ?, Pasos = ?, Tiempo = ?, Precio = ?, Fecha_Creacion = ?, Valoracion = ? WHERE Id = ?";

            // Prepara la declaración SQL
            $stmt = $conn->prepare($query);

            // Verifica si la receta existe antes de intentar editarla
            $recetaExiste = $this->buscarReceta($recetaDTO->getId());

            if($recetaExiste)
            {
                // Obtiene los datos de la receta del DTO
                $id = $recetaDTO->getId();
                $nombre = $recetaDTO->getNombre();
                $autor = $recetaDTO->getAutor();
                $descripcion = $recetaDTO->getDescripcion();
                $pasos = json_encode($recetaDTO->getPasos());
                $tiempo = $recetaDTO->getTiempo();
                $precio = $recetaDTO->getPrecio();
                $fechaCreacion = $recetaDTO->getFechaCreacion();
                $valoracion = $recetaDTO->getValoracion();

                // Asocia los parámetros de la consulta con los valores obtenidos
                $stmt->bind_param("sissidsdi", $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion, $id);

                // Si la consulta se ejecuta correctamente, crea el DTO de la receta editada
                if ($stmt->execute()) {
                    $editedRecetaDTO = new recetaDTO($id, $nombre, $autor, $descripcion, json_decode($pasos, true), $tiempo, $precio, $fechaCreacion, $valoracion);
                }
            }

        } catch(mysqli_sql_exception $e)
        {
            // Si la receta no existe (error de integridad)
            if ($conn->sqlstate == 23000) 
            { 
                throw new recetaNotExistException("No existe la receta '{$recetaDTO->recetaName()}'");
            }

            // Lanza cualquier otro tipo de excepción
            throw $e;
        }

        // Retorna el DTO de la receta editada
        return $editedRecetaDTO;
    }

    // Función pública para eliminar una receta de la base de datos
    public function borrarReceta($recetaDTO)
    {
        $deletedRecetaDTO = false;

        try
        {
            // Obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Prepara la consulta SQL para eliminar la receta
            $query = "DELETE FROM recetas WHERE recetaId = ?";

            // Prepara la declaración SQL
            $stmt = $conn->prepare($query);

            // Obtiene el ID de la receta del DTO
            $id = $recetaDTO->getId();

            // Asocia el parámetro de la consulta con el ID de la receta
            $stmt->bind_param("i", $id);

            // Si la consulta se ejecuta correctamente, retorna el DTO de la receta eliminada
            if ($stmt->execute())
            {
                $deletedRecetaDTO = $recetaDTO;
            }

        } catch(mysqli_sql_exception $e)
        {
            // Si se detecta un error de clave referencial (no se puede eliminar debido a dependencias)
            if ($conn->sqlstate == 23000) 
            { 
                throw new recetaNotExistException("No existe la receta '{$recetaDTO->recetaName()}'");
            }

            // Lanza cualquier otro tipo de excepción
            throw $e;
        }

        // Retorna el DTO de la receta eliminada
        return $deletedRecetaDTO;
    }

}
?>
