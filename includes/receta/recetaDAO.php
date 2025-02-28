<?php

require("IReceta.php");
require("recetaDTO.php");
require(__DIR__ . "/../comun/baseDAO.php");
require("recetaAlreadyExistException.php");

class recetaDAO extends baseDAO implements IReceta
{
    public function __construct()
    {

    }

    private function buscarReceta($recetId)
    {
        //Evita consultas que no sean string
        $escRecetaId = $this->realEscapeString($recetaId);

        //Conexion con la base de datos (Patron Singleton)
        $conn = application::getInstance()->getConexionBd();

        //Consulta
        $query = "SELECT * FROM recetas WHERE recetaId = ?";

        //Conecta con la base de datos
        $stmt = $conn->prepare($query);

        //Asocia %esRecetaName con el resultado
        $stmt->bind_param("i", $escRecetaId);

        //Ejecuta la consulta
        $stmt->execute();

        //Asocia las columans qeu se obtendran de la consulta con variables php
        $stmt->bind_result($Id, $Nombre, $Autor, $Descripcion, $Pasos, $Tiempo, $Precio, $Fecha_Creacion, $Valoracion);

        if ($stmt->fetch())
        {
            //Crea un objeto receta con los datos
            $receta = new recetaDTO($Id, $Nombre, $Autor, $Descripcion, $Pasos, $Tiempo, $Precio, $Fecha_Creacion, $Valoracion);

            $stmt->close();

            return $receta;
        }

        return false;
    }

    public function create($recetaDTO)
    {
        $createdRecetaDTO = false;

        try
        {
            $conn = application::getInstance()->getConexionBd();

            $query = "INSERT INTO recetas (Nombre, Autor, Descripcion, Pasos, Tiempo, Precio, Fecha_Creacion, Valoracion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($query);

            // Obtener valores del DTO y limpiar entradas para evitar inyección SQL
            $nombre = $recetaDTO->getNombre();
            $autor = $recetaDTO->getAutor();
            $descripcion = $recetaDTO->getDescripcion();
            $pasos = $recetaDTO->getPasos();
            $tiempo = $recetaDTO->getTiempo();
            $precio = $recetaDTO->getPrecio();
            $fechaCreacion = $recetaDTO->getFechaCreacion(); 
            $valoracion = $recetaDTO->getValoracion();

            //Definimos los tipos como int,string,string,string,string,int,decimal,string,decimal
            $stmt->bind_param("issssidsd", $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion);

            if ($stmt->execute())
            {
                $idReceta = $conn->insert_id;
                
                $createdRecetaDTO = new recetaDTO($idReceta, $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion);

                return $createdRecetaDTO;
            }
        }
        catch(mysqli_sql_exception $e)
        {
            // código de violación de restricción de integridad (PK)

            if ($conn->sqlstate == 23000) 
            { 
                throw new recetaAlreadyExistException("Ya existe la receta '{$recetaDTO->recetaName()}'");
            }

            throw $e;
        }

        return $createdRecetaDTO;
    }

    public function edit($recetaDTO)
    {
        $editedRecetaDTO = false;

        try
        {
            $conn = application::getInstance()->getConexionBd();

            //Preparamos la consulta
            $query = "UPDATE recetas SET Nombre = ?, Autor = ?, Descripcion = ?, Pasos = ?, Tiempo = ?, Precio = ?, Fecha_Creacion = ?, Valoracion = ? WHERE Id = ?";

            $stmt = $conn->prepare($query);

            $recetaExiste = $this->buscarReceta($recetaDTO->getId());

            if($recetaExiste)
            {

            }




        } catch(mysqli_sql_exception $e)
        {
            // código de violación de restricción de integridad (PK)

            if ($conn->sqlstate == 23000) 
            { 
                throw new recetaNotExistException("No existe la receta '{$recetaDTO->recetaName()}'");
            }

            throw $e;
        }

        return $editedRecetaDTO;
    }

    public function delete($recetaDTO)
    {
        $deletedRecetaDTO = false;

        try
        {
            $conn = application::getInstance()->getConexionBd();

            //Preparamos la consulta
            $query = "UPDATE recetas SET Nombre = ?, Autor = ?, Descripcion = ?, Pasos = ?, Tiempo = ?, Precio = ?, Fecha_Creacion = ?, Valoracion = ? WHERE Id = ?";

            $stmt = $conn->prepare($query);





        } catch(mysqli_sql_exception $e)
        {
            // código de violación de restricción de integridad (PK)

            if ($conn->sqlstate == 23000) 
            { 
                throw new recetaNotExistException("No existe la receta '{$recetaDTO->recetaName()}'");
            }

            throw $e;
        }

        return $deletedRecetaDTO;
    }

}
?>