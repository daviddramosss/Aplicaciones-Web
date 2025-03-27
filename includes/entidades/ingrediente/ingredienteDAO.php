<?php

namespace es\ucm\fdi\aw\entidades\ingrediente;
use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;
// require_once("IIngrediente.php"); 
// require_once("IngredienteDTO.php"); 
// require_once(__DIR__ . "/../../comun/baseDAO.php"); 

// Definición de la clase IngredienteDAO, que implementa la interfaz IIngrediente y extiende baseDAO
class IngredienteDAO extends baseDAO implements IIngrediente {

    // Constructor de la clase
    public function __construct()
    {
        
    }

    // Método para crear un nuevo ingrediente (aún no implementado)
    public function crearIngrediente($ingredienteDTO)
    {
        // Implementar después
    }

    // Método para editar un ingrediente existente (aún no implementado)
    public function editarIngrediente($ingredienteDTO)
    {
        // Implementar después
    }

    // Método para eliminar un ingrediente (aún no implementado)
    public function eliminarIngrediente($ingredienteDTO)
    {
        // Implementar después
    }

    // Método para obtener la lista de ingredientes desde la base de datos
    public function obtenerIngredientes()
    {
        try
        {
            // Se obtiene la conexión a la base de datos a través de la aplicación
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener los ingredientes
            $query = "SELECT id, Nombre FROM ingredientes"; // Asegurar que 'id' también se obtiene

            // Se prepara la consulta
            $stmt = $conn->prepare($query);
            $stmt->execute();

            $ingredientes = [];

            // Se obtiene el resultado de la consulta
            $result = $stmt->get_result();
            if ($result->num_rows > 0)   
            {
                // Se recorren los resultados y se almacenan en un array
                while ($row = $result->fetch_assoc())
                {
                    $ingredientes[] = [
                        "id" => $row['id'],
                        "nombre" => $row['Nombre']
                    ];
                }
            }

            // Se cierra la consulta preparada
            $stmt->close();

            // Se devuelve el array con los ingredientes
            return $ingredientes;
            
        } catch (mysqli_sql_exception $e) {
            // Captura de excepción en caso de error en la base de datos

            // Código de violación de restricción de integridad (PK)
            if ($conn->sqlstate == 23000) 
            { 
                // Implementar luego la excepción correctamente
                // throw new recetaNotExistException("No existe la receta '{$recetaDTO->recetaName()}'");
            }

            // Se relanza la excepción para su manejo en niveles superiores
            throw $e;
        }
    }
    
}
?>
