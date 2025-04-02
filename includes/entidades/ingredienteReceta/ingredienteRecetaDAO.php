<?php

namespace es\ucm\fdi\aw\entidades\ingredienteReceta;
use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;
use Exception;
// require_once("IIngredienteReceta.php");
// require_once("ingredienteRecetaDTO.php");
// require_once(__DIR__ . "/../../comun/baseDAO.php");

// Clase que maneja la persistencia de los ingredientes de una receta
class ingredienteRecetaDAO extends baseDAO implements IIngredienteReceta
{
    // Constructor de la clase
    public function __construct()
    {
    }

    // Método privado para buscar ingredientes por su ID
    private function buscarPorIngrediente($ingredienteId)
    {
        // Implementar más adelante
    }

    // Método privado para buscar recetas por su ID
    private function buscarPorRecetaId($recetaId)
    {
        // Implementar más adelante
    }

    // Método para crear un nuevo ingrediente en una receta
    public function crearIngredienteReceta($ingredienteRecetaDTO)
    {
        $createdIngredienteReceta = false;

        try
        {
            // Obtener la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para insertar un nuevo ingrediente en la receta
            $query = "INSERT INTO receta_ingrediente (Receta, Ingrediente, Cantidad, Magnitud) VALUES (?, ?, ?, ?)";
            
            // Preparar la consulta
            $stmt = $conn->prepare($query);

            if (!$stmt)
            {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Obtener los valores desde el DTO
            $recetaId = $ingredienteRecetaDTO->getRecetaId();
            $ingredienteId = $ingredienteRecetaDTO->getIngredienteId(); // Posible error tipográfico en el método "gerIngredienteId()"
            $cantidad = $ingredienteRecetaDTO->getCantidad();
            $magnitud = $ingredienteRecetaDTO->getMagnitud();

            // Definir los tipos de parámetros y enlazarlos a la consulta preparada
            $stmt->bind_param("iidi", $recetaId, $ingredienteId, $cantidad, $magnitud);

            // Ejecutar la consulta y verificar si se insertó correctamente
            if ($stmt->execute())
            {
                // Crear y devolver un nuevo objeto DTO con los datos insertados
                $createdRecetaDTO = new ingredienteRecetaDTO($recetaId, $ingredienteId, $cantidad, $magnitud);
                return $createdRecetaDTO;
            }
        }
        catch(mysqli_sql_exception $e)
        {
            // Manejo de excepciones SQL
            throw $e;
        }
        
        return $createdIngredienteReceta;
    }

    // Método para editar un ingrediente en una receta (pendiente de implementación)
    public function editarIngredienteReceta($ingredienteRecetaDTO)
    {
        try 
        {
             // Obtener la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Primero, verificamos si el ingrediente ya está en la receta
            $queryCheck = "SELECT * FROM receta_ingrediente WHERE Receta = ? AND Ingrediente = ?";
            // Preparar la consulta
            $stmtCheck = $conn->prepare($queryCheck);

            if (!$stmtCheck) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Obtener los valores desde el DTO
            $recetaId = $ingredienteRecetaDTO->getRecetaId();
            $ingredienteId = $ingredienteRecetaDTO->getIngredienteId();
            $stmtCheck->bind_param("ii", $recetaId, $ingredienteId);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows > 0) {
                // Si el ingrediente ya está en la receta, actualizamos la cantidad y magnitud
                $queryUpdate = "UPDATE receta_ingrediente SET Cantidad = ?, Magnitud = ? WHERE Receta = ? AND Ingrediente = ?";
                $stmtUpdate = $conn->prepare($queryUpdate);

                if (!$stmtUpdate) {
                    throw new Exception("Error en la preparación de la consulta: " . $conn->error);
                }

                $cantidad = $ingredienteRecetaDTO->getCantidad();
                $magnitud = $ingredienteRecetaDTO->getMagnitud();
                $stmtUpdate->bind_param("diii", $cantidad, $magnitud, $recetaId, $ingredienteId);
                $stmtUpdate->execute();
            } else {
                //EN PRINCIPIO NO SE HACE AQUI
                // Si no existe, lo insertamos como nuevo ingrediente
                //return $this->crearIngredienteReceta($ingredienteRecetaDTO);
            }

            return new ingredienteRecetaDTO($recetaId, $ingredienteId, $cantidad, $magnitud);
        }
        catch (mysqli_sql_exception $e)
        {
            throw $e;
        }
    }
    

    // Método para eliminar un ingrediente de una receta (pendiente de implementación)
    public function borrarIngredienteReceta($ingredienteRecetaDTO)
    {
        try 
        {
            // Obtener la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Obtener los valores desde el DTO
            $recetaId = $ingredienteRecetaDTO->getRecetaId();
            $ingredienteId = $ingredienteRecetaDTO->getIngredienteId();

            // Consulta SQL para eliminar el ingrediente
            $query = "DELETE FROM receta_ingrediente WHERE Receta = ? AND Ingrediente = ?";
            
            // Preparar la consulta
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Enlazar los parámetros
            $stmt->bind_param("ii", $recetaId, $ingredienteId);

            // Ejecutar la consulta
            if (!$stmt->execute()) {
                throw new Exception("Error al eliminar el ingrediente: " . $stmt->error);
            }

            // Cerrar la declaración
            $stmt->close();
        }
        catch (mysqli_sql_exception $e)
        {
            throw $e;
        }
        
    }

    public function buscarIngredienteReceta($recetaId)
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para obtener los ingredientes de la receta
        $query = "SELECT i.Nombre, ri.Cantidad, m.Nombre, i.ID, ri.Magnitud
                FROM receta_ingrediente ri
                JOIN ingredientes i ON ri.Ingrediente = i.ID
                JOIN magnitudes m ON ri.Magnitud = m.ID
                WHERE ri.Receta = ?";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el valor del ID de la receta
        $stmt->bind_param("i", $recetaId);

        // Ejecuta la consulta
        if ($stmt->execute()) 
        {
            // Declara las variables donde se almacenarán los resultados
            $ingrediente = $cantidad = $magnitud = $id = $id_Magnitud = null;

            // Asocia las columnas de la consulta con las variables PHP
            $stmt->bind_result($ingrediente, $cantidad, $magnitud, $id, $id_Magnitud);

            // Array donde se almacenarán los ingredientes
            $ingredientes = [];

            // Recorre los resultados y los guarda en el array
            while ($stmt->fetch()) 
            {
                $ingredientes[] = [
                    "Ingrediente" => $ingrediente,
                    "Cantidad" => $cantidad,
                    "Magnitud" => $magnitud,
                    "ID" => $id,
                    "ID_Magnitud" => $id_Magnitud
                ];
            }

            // Cierra la declaración
            $stmt->close();

            // Retorna el array con los ingredientes
            return $ingredientes;
        }

        // Si no hay ingredientes o hay un error, retorna un array vacío
        return [];
    }
}

?>
