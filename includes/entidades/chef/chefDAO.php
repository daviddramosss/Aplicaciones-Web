<?php

namespace es\ucm\fdi\aw\entidades\chef;

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;

class chefDAO extends baseDAO implements IChef
{

    public function __construct()
    {
    }
    
    public function crearChef($chefDTO)
    {
        //Implementar luego
    }

    public function editarChef($chefDTO)
    {
        //Implementar luego
    }

    public function borrarChef($chefDTO)
    {
        //Implementar luego
    }

    public function informacionChef($userDTO)
    {

        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        $query = "SELECT * FROM chefs WHERE Usuario = ?";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        $id = $userDTO->getId();
        // Asocia el parámetro de la consulta con el ID de la receta
        $stmt->bind_param("i", $id);

        // Ejecuta la consulta
        if($stmt->execute())
        {
            // Obtiene el resultado de la consulta
            $result = $stmt->get_result();
            $chef = null;

            // Si hay resultados, los recorremos y creamos DTOs de recetas
            if ($result->num_rows > 0) 
            {
                while ($row = $result->fetch_assoc()) 
                {
                    $chef = new chefDTO(
                        $row["Usuario"],
                        $row["DNI"],
                        $row["Cuenta_bancaria"],
                        $row["Saldo"]
                    );
                }
            }
        }

            $stmt->close();

            return $chef;
    }
}

?>