<?php

require_once("IIngredienteReceta.php");
require_once("ingredienteRecetaDTO.php");
require_once(__DIR__ . "/../comun/baseDAO.php");

class ingredienteRecetaDAO extends baseDAO implements IIngredienteReceta
{

    public function __construct()
    {

    }

    private function buscarPorIngrediente($ingredienteId)
    {
        //Implementar más adelante
    }

    private function buscarPorRecetaId($recetaId)
    {
        //Implementar más adelante
    }

    public function crearIngredienteReceta($ingredienteRecetaDTO)
    {
        $createdIngredienteReceta = false;

        try
        {
            $conn = application::getInstance()->getConexionBd();

            $query = "INSERT INTO receta_ingrediente (Receta, Ingrediente, Cantidad, Magnitud) VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($query);

            if (!$stmt)
            {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            $recetaId = $ingredienteRecetaDTO->getRecetaId();
            $ingredienteId = $ingredienteRecetaDTO->gerIngredienteId();
            $cantidad = $ingredienteRecetaDTO->getCantidad();
            $magnitud = $ingredienteRecetaDTO->getMagnitud();

            //Definimos los tipos
            $stmt->bind_param("iiis", $recetaId, $ingredienteId, $cantidad, $magnitud);

            if ($stmt->execute())
            {
                $createdRecetaDTO = new ingredienteRecetaDTO($recetaId, $ingredienteId, $cantidad, $magnitud);

                return $createdRecetaDTO;
            }
        }
        catch(mysqli_sql_exception $e)
        {
            throw $e;
        }
        return $createdIngredienteReceta;
    }

    public function editarIngredienteReceta($ingredienteRecetaDTO)
    {
        //Implementar más adelante
    }

    public function borrarIngredienteReceta($ingredienteRecetaDTO)
    {
        //Implementar más adelante
    }
    
}

?>