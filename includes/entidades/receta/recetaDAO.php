<?php

namespace es\ucm\fdi\aw\entidades\receta;
require_once(__DIR__ . "/../../config.php");

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;
use es\ucm\fdi\aw\entidades\ingredienteReceta\ingredienteRecetaAppService;
use es\ucm\fdi\aw\entidades\etiquetaReceta\etiquetaRecetaAppService;

// La clase recetaDAO hereda de baseDAO e implementa la interfaz IReceta
class recetaDAO extends baseDAO implements IReceta
{
    // Constructor vacío
    public function __construct()
    {
    }

    // Función privada para buscar una receta en la base de datos por su ID
    public function buscarReceta($recetaId)
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para buscar la receta
        $query = "SELECT * FROM recetas WHERE ID = ?";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el valor del ID
        $stmt->bind_param("i", $recetaId);

        // Ejecuta la consulta
        if($stmt->execute())
        {

            // Declara las variables donde se almacenarán los resultados
            $Id = $Nombre = $Autor = $Descripcion = $Pasos = $Tiempo = $Precio = $Fecha_Creacion = $Valoracion = $ruta = null ;

            // Asocia las columnas de la consulta con las variables PHP
            $stmt->bind_result($Id, $Nombre, $Autor, $Descripcion, $Pasos, $Tiempo, $Precio, $Fecha_Creacion, $Valoracion, $ruta);

            // Si se encontró la receta
            if ($stmt->fetch())
            {
                // Crea un objeto recetaDTO con los datos obtenidos
                $receta = new recetaDTO($Id, $Nombre, $Autor, $Descripcion, $Pasos, $Tiempo, $Precio, $Fecha_Creacion, $Valoracion, $ruta);

                // Cierra la declaración
                $stmt->close();

                // Retorna el objeto receta
                return $receta;
            }
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
            $query = "INSERT INTO recetas (Nombre, Autor, Descripcion, Pasos, Tiempo, Precio, Fecha_Creacion, Valoracion, Ruta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
            $ruta = $recetaDTO->getRuta();

            // Asocia los parámetros de la consulta con los valores obtenidos
            $stmt->bind_param("sissidsds", $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion, $ruta);

            // Si la consulta se ejecuta correctamente
            if ($stmt->execute())
            {
                // Obtiene el ID de la receta insertada
                $id = $conn->insert_id;

                // Crea un DTO de receta con los datos insertados
                $createdRecetaDTO = new recetaDTO($id, $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion, $ruta);
                    
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
            $query = "UPDATE recetas SET Nombre = ?, Autor = ?, Descripcion = ?, Pasos = ?, Tiempo = ?, Precio = ?, Fecha_Creacion = ?, Valoracion = ?, Ruta = ?WHERE Id = ?";

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
                $ruta = $recetaDTO->getRuta();

                // Asocia los parámetros de la consulta con los valores obtenidos
                $stmt->bind_param("sissidsdsi", $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion, $ruta, $id);

                // Si la consulta se ejecuta correctamente, crea el DTO de la receta editada
                if ($stmt->execute()) {
                    $editedRecetaDTO = new recetaDTO($id, $nombre, $autor, $descripcion, json_decode($pasos, true), $tiempo, $precio, $fechaCreacion, $valoracion, $ruta);
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

    public function mostarRecetasPorAutor($userDTO)
    {
        try
        {
            // Obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Prepara la consulta SQL para buscar la receta
            $query = "SELECT * FROM recetas WHERE Autor = ?";

            // Prepara la declaración SQL
            $stmt = $conn->prepare($query);

            $autor = $userDTO->getId();
            // Asocia el parámetro de la consulta con el ID de la receta
            $stmt->bind_param("i", $autor);

            // Ejecuta la consulta
            if($stmt->execute())
            {
                // Obtiene el resultado de la consulta
                $result = $stmt->get_result();
                $recetas = [];

                // Si hay resultados, los recorremos y creamos DTOs de recetas
                if ($result->num_rows > 0) 
                {
                    while ($row = $result->fetch_assoc()) 
                    {
                        $recetas[] = new recetaDTO(
                            $row["ID"],
                            $row["Nombre"],
                            $row["Autor"],
                            $row["Descripcion"],
                            json_decode($row["Pasos"], true),
                            $row["Tiempo"],
                            $row["Precio"],
                            $row["Fecha_Creacion"],
                            $row["Valoracion"],
                            $row["Ruta"]
                        );
                    }
                }
            }

            $stmt->close();

            return $recetas;
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function mostrarRecetasIndex($criterio)
    {
        try
        {
            // Obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            $ordenamiento = [
                'fecha' => "SELECT ID, Nombre, Ruta FROM recetas ORDER BY Fecha_Creacion DESC",
                'etiqueta_principal' => "SELECT r.ID, r.Nombre, r.Ruta FROM recetas r JOIN receta_etiqueta re ON r.ID = re.Receta 
                                        JOIN etiquetas e ON re.Etiqueta = e.ID WHERE e.Nombre = 'Principal'",
                'precio' => "SELECT ID, Nombre, Ruta FROM recetas ORDER BY Precio ASC",
                'ingrediente' => "SELECT r.ID, r.Nombre, r.Ruta, COUNT(ri.Ingrediente) AS num_ingredientes FROM recetas r 
                                LEFT JOIN receta_ingrediente ri ON r.ID = ri.Receta GROUP BY r.ID ORDER BY num_ingredientes DESC",
                'default' => "SELECT id, Nombre, Ruta FROM recetas"
            ];

            // Ordenamos por criterio y sino mostramos todos
            $query = $ordenamiento[$criterio] ?? $ordenamiento['default'];

            $stmt = $conn->prepare($query);

            if($stmt->execute())
            {
                // Obtiene el resultado de la consulta
                $result = $stmt->get_result();
                $recetas = [];

                // Si hay resultados, los recorremos y creamos DTOs de recetas
                if ($result->num_rows > 0)  
                {
                    while ($row = $result->fetch_assoc()) 
                    {
                        $recetas[] = new recetaDTO(
                            $row["ID"],
                            $row["Nombre"],
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            $row["Ruta"]
                        );
                    }
                }
            }

            $stmt->close();

            return $recetas;
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function mostrarTodasLasRecetas()
    {
        try
        {
            // Obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Prepara la consulta SQL para buscar la receta
            $query = "SELECT * FROM recetas";

            // Prepara la declaración SQL
            $stmt = $conn->prepare($query);

            // Ejecuta la consulta
            if($stmt->execute())
            {
                // Obtiene el resultado de la consulta
                $result = $stmt->get_result();
                $recetas = [];

                // Si hay resultados, los recorremos y creamos DTOs de recetas
                if ($result->num_rows > 0) 
                {
                    while ($row = $result->fetch_assoc()) 
                    {
                        $recetas[] = new recetaDTO(
                            $row["ID"],
                            $row["Nombre"],
                            $row["Autor"],
                            $row["Descripcion"],
                            json_decode($row["Pasos"], true),
                            $row["Tiempo"],
                            $row["Precio"],
                            $row["Fecha_Creacion"],
                            $row["Valoracion"],
                            $row["Ruta"]
                        );
                    }
                }
            }

            $stmt->close();

            return $recetas;
        }
        catch(Exception $e)
        {
        throw $e;
        }
    }
}
?>
