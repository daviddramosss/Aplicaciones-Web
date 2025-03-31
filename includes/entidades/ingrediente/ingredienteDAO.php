<?php
namespace es\ucm\fdi\aw\entidades\ingrediente;

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;

class IngredienteDAO extends baseDAO implements IIngrediente {

    // Constructor de la clase
    public function __construct()
    {
        
    }

    // Método para crear un nuevo ingrediente
    public function crearIngrediente($ingredienteDTO)
    {
        try {
            // Se obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para insertar un ingrediente
            $query = "INSERT INTO ingredientes (Nombre) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $ingredienteDTO->getNombre());
            $stmt->execute();

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    // Método para editar un ingrediente existente
    public function editarIngrediente($ingredienteDTO)
    {
        try {
            // Se obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para actualizar un ingrediente
            $query = "UPDATE ingredientes SET Nombre = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $ingredienteDTO->getNombre(), $ingredienteDTO->getId());
            $stmt->execute();

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    // Método para eliminar un ingrediente
    public function eliminarIngrediente($ingredienteDTO)
    {
        try {
            // Se obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para eliminar el ingrediente
            $query = "DELETE FROM ingredientes WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $ingredienteDTO->getId());
            $stmt->execute();

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    // Método para obtener la lista de ingredientes desde la base de datos
    public function obtenerIngredientes()
    {
        try {
            // Se obtiene la conexión a la base de datos
            $conn = application::getInstance()->getConexionBd();

            // Consulta SQL para obtener los ingredientes
            $query = "SELECT id, Nombre FROM ingredientes";

            // Se prepara la consulta
            $stmt = $conn->prepare($query);
            $stmt->execute();

            $ingredientes = [];
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Se recorren los resultados y se almacenan en un array
                while ($row = $result->fetch_assoc()) {
                    $ingredientes[] = [
                        "id" => $row['id'],
                        "nombre" => $row['Nombre']
                    ];
                }
            }

            // Se cierra la consulta
            $stmt->close();

            return $ingredientes;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }
}
?>
