<?php

namespace es\ucm\fdi\aw\entidades\ingredienteReceta;

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;

// Clase que maneja la persistencia de los ingredientes de una receta
class ingredienteRecetaDAO extends baseDAO implements IIngredienteReceta
{
    // Constructor de la clase
    public function __construct()
    {
    }

    // Método para crear un nuevo ingrediente en una receta
    public function crearIngredienteReceta($ingredienteRecetaDTO)
    {
        $createdIngredienteReceta = false;

        // Obtener la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Consulta SQL para insertar un nuevo ingrediente en la receta
        $query = "INSERT INTO receta_ingrediente (Receta, Ingrediente, Cantidad, Magnitud) VALUES (?, ?, ?, ?)";
        
        // Preparar la consulta
        $stmt = $conn->prepare($query);

        // Obtener los valores desde el DTO
        $recetaId = $ingredienteRecetaDTO->getRecetaId();
        $ingredienteId = $ingredienteRecetaDTO->getIngrediente();
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

        return $createdIngredienteReceta;
    }

    // Método para eliminar un ingrediente de una receta (pendiente de implementación)
    public function borrarIngredienteReceta($recetaDTO)
    {
        $borrado = false;

        // Obtener la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Consulta SQL para eliminar el ingrediente
        $query = "DELETE FROM receta_ingrediente WHERE Receta = ?";
        
        // Preparar la consulta
        $stmt = $conn->prepare($query);

        // Enlazar los parámetros
        $stmt->bind_param("i", $recetaDTO->getId());

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $borrado = true;
        }

        // Cerrar la declaración
        $stmt->close();

        return $borrado;     
    }

    public function buscarIngredienteReceta($recetaDTO, $criterio)
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();

        $ordenamiento = [
            'ids' => "SELECT Ingrediente, Cantidad, Magnitud FROM receta_ingrediente WHERE Receta = ?",
            'nombres' => "SELECT i.Nombre AS Ingrediente, ri.Cantidad AS Cantidad, m.Nombre AS Magnitud
                FROM receta_ingrediente ri
                JOIN ingredientes i ON ri.Ingrediente = i.ID
                JOIN magnitudes m ON ri.Magnitud = m.ID
                WHERE ri.Receta = ?"
        ];

        $query = $ordenamiento[$criterio] ?? $ordenamiento['ids'];

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el valor del ID de la receta
        $stmt->bind_param("i", $recetaDTO->getId());

        // Ejecuta la consulta
        if ($stmt->execute()) 
        {
            // Array donde se almacenarán los ingredientes
            $result = $stmt->get_result();
            $ingredientes = [];

            // Recorre los resultados y los guarda en el array
            if ($result->num_rows > 0)  
            {
                while ($row = $result->fetch_assoc()) {
                    $ingredientes[] = new ingredienteRecetaDTO(
                        null,
                        $row["Ingrediente"],
                        $row["Cantidad"],
                        $row["Magnitud"]
                    );
                }
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
