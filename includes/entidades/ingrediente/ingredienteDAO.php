<?php
namespace es\ucm\fdi\aw\entidades\ingrediente;

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;

class IngredienteDAO extends baseDAO implements IIngrediente {

    public function __construct() {}

    public function crearIngrediente($ingredienteDTO) {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "INSERT INTO ingredientes (Nombre) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $ingredienteDTO->getNombre());
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function editarIngrediente($ingredienteDTO) {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "UPDATE ingredientes SET Nombre = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $ingredienteDTO->getNombre(), $ingredienteDTO->getId());
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function eliminarIngrediente($ingredienteDTO) {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "DELETE FROM ingredientes WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $ingredienteDTO->getId());
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function obtenerIngredientes() {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "SELECT id, Nombre FROM ingredientes";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            $ingredientes = [];
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ingredientes[] = [
                        "id" => $row['id'],
                        "nombre" => $row['Nombre']
                    ];
                }
            }

            $stmt->close();
            return $ingredientes;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    // ✅ Mantén solo esta versión
    public function obtenerPlatosPorIngrediente($ingredienteId) {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "SELECT platos.id, platos.nombre
                      FROM platos
                      JOIN platos_ingredientes ON platos.id = platos_ingredientes.plato_id
                      WHERE platos_ingredientes.ingrediente_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $ingredienteId);
            $stmt->execute();

            $platos = [];
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $platos[] = [
                        "id" => $row['id'],
                        "nombre" => $row['nombre']
                    ];
                }
            }

            $stmt->close();
            return $platos;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function buscarIngredientesPorNombre($termino) {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "SELECT id, Nombre FROM ingredientes WHERE Nombre LIKE ?";
            $stmt = $conn->prepare($query);
            $likeTerm = '%' . $termino . '%';
            $stmt->bind_param("s", $likeTerm);
            $stmt->execute();

            $ingredientes = [];
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ingredientes[] = [
                        "id" => $row['id'],
                        "nombre" => $row['Nombre']
                    ];
                }
            }

            $stmt->close();
            return $ingredientes;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }
}
?>
