<?php

namespace es\ucm\fdi\aw\entidades\recetaComprada;
use es\ucm\fdi\aw\entidades\receta\{recetaDTO};


use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;


// La clase recetaDAO hereda de baseDAO e implementa la interfaz IReceta
class recetaCompradaDAO extends baseDAO implements IRecetaComprada
{
    // Constructor vacío
    public function __construct()
    {
    }

    public function mostrarRecetasPorComprador($recetaCompradaDTO)
    {
        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        $recetas = []; // Guardará las recetas encontradas

        // Prepara la consulta SQL para buscar las recetas compradas por el usuario
        $query = "
            SELECT r.ID, r.Nombre, r.Ruta 
            FROM receta_comprada rc
            JOIN recetas r ON rc.Receta = r.ID
            WHERE rc.Usuario = ?
        ";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el ID del comprador
        $comprador = $recetaCompradaDTO->getUsuario();
        $stmt->bind_param("i", $comprador);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Obtiene el resultado de la consulta
            $result = $stmt->get_result();

            // Si hay resultados, los recorremos
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Guardamos la info de la receta comprada
                    $recetas[] = new recetaDTO(
                        $row["ID"],      // ID de la receta
                        $row["Nombre"],  // Nombre de la receta
                        null,            // Otros parámetros que puedes necesitar
                        null,
                        null,
                        null,
                        null,
                        null,
                        $row["Ruta"]     // Ruta de la receta
                    );
                }
            }
        }

        // Cierra la declaración
        $stmt->close();

        return $recetas;
    }

    public function comprarReceta($recetaCompradaDTO)
    {
        $comprada = false;

        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para comprar la receta
        $query = "INSERT INTO receta_comprada (Usuario, Receta) VALUES (?, ?)";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el ID del comprador y la receta
        $usuario = $recetaCompradaDTO->getUsuario();
        $receta = $recetaCompradaDTO->getReceta();
        $stmt->bind_param("ii", $usuario, $receta);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Devuelve true si la compra se ha realizado con éxito
            $comprada = true;
        }

        $stmt->close();
        
        // Devuelve false si la compra ha fallado
        return $comprada;
        
    }

    public function esComprador($recetaCompradaDTO)
    {
        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para comprar la receta
        $query = "SELECT * FROM receta_comprada WHERE Usuario = ? AND Receta = ?"; 

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el ID del comprador
        $comprador = $recetaCompradaDTO->getUsuario();
        $recetaId = $recetaCompradaDTO->getReceta();
        $stmt->bind_param("ii", $comprador, $recetaId);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Obtiene el resultado de la consulta
            $result = $stmt->get_result();

            // Si hay resultados significa que si es comprador
            if ($result->num_rows > 0) {
                $stmt->close();
                return true;
            }
        }

        // Cierra la declaración
        $stmt->close();

        return false;
    }

}  
?>