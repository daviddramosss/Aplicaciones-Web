<?php

// Se incluyen las dependencias necesarias
require_once("IIngredienteReceta.php");
require_once("ingredienteRecetaDTO.php");
require_once(__DIR__ . "/../../comun/baseDAO.php");

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
            $ingredienteId = $ingredienteRecetaDTO->gerIngredienteId(); // Posible error tipográfico en el método "gerIngredienteId()"
            $cantidad = $ingredienteRecetaDTO->getCantidad();
            $magnitud = $ingredienteRecetaDTO->getMagnitud();

            // Definir los tipos de parámetros y enlazarlos a la consulta preparada
            $stmt->bind_param("iids", $recetaId, $ingredienteId, $cantidad, $magnitud);

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
        // Implementar más adelante
    }

    // Método para eliminar un ingrediente de una receta (pendiente de implementación)
    public function borrarIngredienteReceta($ingredienteRecetaDTO)
    {
        // Implementar más adelante
    }
}

?>
