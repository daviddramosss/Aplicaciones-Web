<?php

namespace es\ucm\fdi\aw\entidades\magnitudes;

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;

class magnitudDAO extends baseDAO implements IMagnitud 
{
    public function __construct()
    {
    }

    public function crearMagnitud($magnitudDTO)
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "INSERT INTO magnitudes (Nombre) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $magnitudDTO->getNombre());
        $stmt->execute();
        $stmt->close();
    }

    public function editarMagnitud($magnitudDTO)
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "UPDATE magnitudes SET Nombre = ? WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $magnitudDTO->getNombre(), $magnitudDTO->getId());
        $stmt->execute();
        $stmt->close();
    }

    public function borrarMagnitud($magnitudDTO)
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "DELETE FROM magnitudes WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $magnitudDTO->getId());
        $stmt->execute();
        $stmt->close();
    }

    public function mostrarMagnitudes()
    {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT ID, Nombre FROM magnitudes";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $magnitudes = [];
        $result = $stmt->get_result();
        if ($result->num_rows > 0) 
        {
            while ($fila = $result->fetch_assoc()) 
            {
                $magnitudes[] = [
                    "id" => $fila['ID'], 
                    "nombre" => $fila['Nombre']
                ];
            }
            $stmt->close();
            $result->free();
        }
        return $magnitudes;
    }
}