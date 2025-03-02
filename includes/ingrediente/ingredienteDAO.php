<?php

require("IIngrediente.php");
require("IngredienteDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");
require(__DIR__ . "/../application.php");


class IngredienteDAO extends baseDAO implements IIngrediente {

    public function __construct()
    {
        
    }

    public function crearIngrediente($ingredienteDTO)
    {
        //Implementar después
    }

    public function editarIngrediente($ingredienteDTO)
    {
        //Implementar después
    }

    public function eliminarIngrediente($ingredienteDTO)
    {
        //Implementar después
    }

    public function obtenerIngredientes()
    {
        try
        {
            $conn = application::getInstance()->getConexionBd();

            $query = "SELECT id, nombre FROM ingredientes";
    
            $stmt = $conn->prepare($query);
            $stmt->execute();
    
            $ingredientes = array();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0)
            {
                while ($row = $result->fetch_assoc())
                {
                    $ingredientes[] = [
                        'id' => $row['id'],
                        'nombre' => $row['nombre']
                    ];
                }
            }
    
            $stmt->close();
    
            return $ingredientes;
            
        }catch(mysqli_sql_exception $e)
        {
              // código de violación de restricción de integridad (PK)

              if ($conn->sqlstate == 23000) 
              { 
                  // Implementar luego la excepcion correctamente
                  // throw new recetaNotExistException("No existe la receta '{$recetaDTO->recetaName()}'");
              }
  
              throw $e;
        }
    }
    
}
?>
