<?php

namespace es\ucm\fdi\aw\entidades\plato;

use es\ucm\fdi\aw\application;
use mysqli;

class PlatoDAO implements IPlato
{
    public function __construct()
    {
        // Inicialización opcional
    }

    // Crear un nuevo plato (solo nombre)
    public function crearPlato(PlatoDTO $platoDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "INSERT INTO platos (nombre) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $platoDTO->getNombre());
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Error al crear plato: " . $e->getMessage());
            throw $e;
        }
    }

    // Editar un plato (solo nombre)
    public function editarPlato(PlatoDTO $platoDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "UPDATE platos SET nombre = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $platoDTO->getNombre(), $platoDTO->getId());
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Error al editar plato: " . $e->getMessage());
            throw $e;
        }
    }

    // Eliminar un plato
    public function eliminarPlato(PlatoDTO $platoDTO)
    {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "DELETE FROM platos WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $platoDTO->getId());
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Error al eliminar plato: " . $e->getMessage());
            throw $e;
        }
    }

    // Obtener todos los platos (solo id y nombre)
    public function obtenerPlatos(): array
    {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "SELECT id, nombre FROM platos";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $platos = [];
            while ($row = $result->fetch_assoc()) {
                $platos[] = new PlatoDTO($row['id'], $row['nombre']);
            }
            $stmt->close();
            return $platos;
        } catch (mysqli_sql_exception $e) {
            error_log("Error al obtener platos: " . $e->getMessage());
            throw $e;
        }
    }

    // Obtener ingredientes asociados a un plato
    public function obtenerIngredientesDePlato($idPlato): array
    {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "SELECT i.id, i.nombre FROM ingredientes i
                      JOIN platos_ingredientes pi ON i.id = pi.id_ingrediente
                      WHERE pi.id_plato = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $idPlato);
            $stmt->execute();
            $result = $stmt->get_result();
            $ingredientes = [];
            while ($row = $result->fetch_assoc()) {
                $ingredientes[] = $row;
            }
            $stmt->close();
            return $ingredientes;
        } catch (mysqli_sql_exception $e) {
            error_log("Error al obtener ingredientes de plato: " . $e->getMessage());
            throw $e;
        }
    }

    // Asociar un ingrediente a un plato
    public function asociarIngrediente($idPlato, $idIngrediente)
    {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "INSERT INTO platos_ingredientes (id_plato, id_ingrediente) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $idPlato, $idIngrediente);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Error al asociar ingrediente a plato: " . $e->getMessage());
            throw $e;
        }
    }

    // Desasociar un ingrediente de un plato
    public function desasociarIngrediente($idPlato, $idIngrediente)
    {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "DELETE FROM platos_ingredientes WHERE id_plato = ? AND id_ingrediente = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $idPlato, $idIngrediente);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            error_log("Error al desasociar ingrediente de plato: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
