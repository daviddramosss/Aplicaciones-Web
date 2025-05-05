<?php
namespace es\ucm\fdi\aw\entidades\etiquetas;

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;

class etiquetasDAO extends baseDAO
{
    public function crearEtiqueta($etiquetaDTO)
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "INSERT INTO etiquetas (nombre) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $etiquetaDTO->getNombre());
        $stmt->execute();
        $stmt->close();
    }

    public function editarEtiqueta($etiquetaDTO)
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "UPDATE etiquetas SET nombre = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $etiquetaDTO->getNombre(), $etiquetaDTO->getId());
        $stmt->execute();
        $stmt->close();
    }

    public function borrarEtiqueta($etiquetaDTO)
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "DELETE FROM etiquetas WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $etiquetaDTO->getId());
        $stmt->execute();
        $stmt->close();
    }

    public function obtenerEtiquetas()
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT id, nombre FROM etiquetas";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $etiquetas = [];
        while ($fila = $result->fetch_assoc()) {
            $etiquetas[] = ["id" => $fila['id'], "nombre" => $fila['nombre']];
        }
        
        $stmt->close();
        return $etiquetas;
    }
}
