<?php
namespace es\ucm\fdi\aw\entidades\ingrediente;

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;

class IngredienteDAO extends baseDAO implements IIngrediente {
    public function __construct() {
        // Constructor vacío, conexión manejada por application::getInstance()
    }

    public function crearIngrediente($ingredienteDTO) {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "INSERT INTO ingredientes (Nombre) VALUES (?)";
            $stmt = $conn->prepare($query);
            $nombre = $ingredienteDTO->getNombre();
            if (empty($nombre)) {
                throw new \Exception("El nombre del ingrediente no puede estar vacío");
            }
            $stmt->bind_param("s", $nombre);
            if (!$stmt->execute()) {
                throw new \Exception("Error al crear el ingrediente");
            }
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            throw new \Exception("Error en la base de datos: " . $e->getMessage());
        }
    }

    public function editarIngrediente($ingredienteDTO) {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "UPDATE ingredientes SET Nombre = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $nombre = $ingredienteDTO->getNombre();
            $id = $ingredienteDTO->getId();
            if (empty($nombre)) {
                throw new \Exception("El nombre del ingrediente no puede estar vacío");
            }
            if (!is_numeric($id)) {
                throw new \Exception("ID inválido");
            }
            $stmt->bind_param("si", $nombre, $id);
            if (!$stmt->execute() || $stmt->affected_rows === 0) {
                throw new \Exception("No se encontró el ingrediente con ID $id");
            }
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            throw new \Exception("Error en la base de datos: " . $e->getMessage());
        }
    }

    public function eliminarIngrediente($ingredienteDTO) {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "DELETE FROM ingredientes WHERE id = ?";
            $stmt = $conn->prepare($query);
            $id = $ingredienteDTO->getId();
            if (!is_numeric($id)) {
                throw new \Exception("ID inválido");
            }
            $stmt->bind_param("i", $id);
            if (!$stmt->execute() || $stmt->affected_rows === 0) {
                throw new \Exception("No se encontró el ingrediente con ID $id");
            }
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            throw new \Exception("Error en la base de datos: " . $e->getMessage());
        }
    }

    public function obtenerIngredientes() {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "SELECT id, Nombre AS nombre FROM ingredientes ORDER BY nombre";
            $result = $conn->query($query);
            $ingredientes = [];
            while ($row = $result->fetch_assoc()) {
                $ingredientes[] = [
                    "id" => (int)$row['id'],
                    "nombre" => $row['nombre']
                ];
            }
            $result->free();
            return $ingredientes;
        } catch (mysqli_sql_exception $e) {
            throw new \Exception("Error en la base de datos: " . $e->getMessage());
        }
    }

    public function buscarIngredientes(string $busqueda): array {
        try {
            $conn = application::getInstance()->getConexionBd();
            $query = "SELECT id, Nombre AS nombre FROM ingredientes WHERE Nombre LIKE ? ORDER BY nombre";
            $stmt = $conn->prepare($query);
            $busqueda = "%" . trim($busqueda) . "%";
            $stmt->bind_param("s", $busqueda);
            $stmt->execute();
            $result = $stmt->get_result();
            $ingredientes = [];
            while ($row = $result->fetch_assoc()) {
                $ingredientes[] = [
                    "id" => (int)$row['id'],
                    "nombre" => $row['nombre']
                ];
            }
            $stmt->close();
            return $ingredientes;
        } catch (mysqli_sql_exception $e) {
            throw new \Exception("Error en la base de datos: " . $e->getMessage());
        }
    }

    public function obtenerPlatosPorIngrediente($ingredienteId) {
        try {
            if (!is_numeric($ingredienteId)) {
                throw new \Exception("ID de ingrediente inválido");
            }
            $conn = application::getInstance()->getConexionBd();
            $query = "SELECT platos.id, platos.nombre
                      FROM platos
                      JOIN platos_ingredientes ON platos.id = platos_ingredientes.plato_id
                      WHERE platos_ingredientes.ingrediente_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $ingredienteId);
            $stmt->execute();
            $result = $stmt->get_result();
            $platos = [];
            while ($row = $result->fetch_assoc()) {
                $platos[] = [
                    "id" => (int)$row['id'],
                    "nombre" => $row['nombre']
                ];
            }
            $stmt->close();
            return $platos;
        } catch (mysqli_sql_exception $e) {
            throw new \Exception("Error en la base de datos: " . $e->getMessage());
        }
    }
}