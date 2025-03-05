<?php

require_once("IEtiquetaReceta.php");
require_once("etiquetaRecetaDTO.php");
require_once(__DIR__ . "/../comun/baseDAO.php");

class etiquetaRecetaDAO extends baseDAO implements IEtiquetaReceta
{
    public function __construct()
    {
        
    }

    public function crearEtiquetaReceta($etiquetaRecetaDTO)
    {
        $crearEtiquetaReceta = false;

        try
        {
            $conn = application::getInstance()->getConexionBd();

            $query = "INSERT INTO receta_etiqueta (Receta, Etiqueta) VALUES (?, ?)";

            $stmt = $conn->prepare($query);

            if (!$stmt)
            {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Obtener valores del DTO y limpiar entradas para evitar inyección SQL
            $recetaId = $etiquetaRecetaDTO->getRecetaId();
            $etiqueta = $etiquetaRecetaDTO->getEtiqueta();

            //Definimos los tipos
            $stmt->bind_param("is", $recetaId, $etiqueta);

            if ($stmt->execute())
            {
                $crearEtiquetaReceta = new etiquetaRecetaDTO($recetaId, $etiqueta);

                return $crearEtiquetaReceta;
            }
        }
        catch(mysqli_sql_exception $e)
        {
            throw $e;
        }
        
        return $crearEtiquetaReceta;
    }

    public function editarEtiquetaReceta($etiquetaRecetaDTO)
    {
        //Implementar más adelante
    }

    public function borrarEtiquetaReceta($etiquetaRecetaDTO)
    {
        //Implementar más adelante
    }
}



?>