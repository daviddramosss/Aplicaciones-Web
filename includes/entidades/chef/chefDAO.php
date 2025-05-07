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
        //Implementación NICO
    }

    public function editarChef($chefDTO)
    {
        //Implementación NICO
    }

    public function borrarChef($chefDTO)
    {
        //Implementación NICO
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

    public function actualizarSaldo($chefDTO, $recetaDTO)
    {
        $actualizado = false;
        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        $query = "UPDATE chefs SET Saldo = ? WHERE Usuario = ?";
 
        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);
 
        $Usuario = $chefDTO->getId();
        $saldo = $chefDTO->getSaldo() + $recetaDTO->getPrecio()*0.85;       //MarketChef se queda una comision del 15%

        $stmt->bind_param("di", $saldo, $Usuario);
 
        // Ejecuta la consulta
        if($stmt->execute())
        {
        $actualizado = true;
        }
 
        $stmt->close();

        return $actualizado;
    }


    public function buscarChefPorID($chefDTO)
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();
        
        // busca en la base de datos un usuario con el email pasado por parámetro
        $query = "SELECT * FROM chefs WHERE Usuario = ?";

        // obtenemos el resultado de la búsqueda
        $stmt = $conn->prepare($query);

        $id = $chefDTO->getId();
        $stmt->bind_param("i", $id);

        
        // Si la búsqueda ha encontrado a un usuario entonces:
        if($stmt->execute())
        {
            $Usuario = $DNI = $Cuenta_Bancaria = $Saldo = null;
            $stmt->bind_result($Usuario, $DNI, $Cuenta_Bancaria, $Saldo);

            if($stmt->fetch())
            {
                $chef = new chefDTO($Usuario, $DNI, $Cuenta_Bancaria, $Saldo);
                return $chef;

            }

            $stmt->close();

        }

        // Si no se ha encontrado ningún usuario con ese email, se devuelve un false
        return false;
    }
}

?>