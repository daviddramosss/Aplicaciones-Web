<?php

require_once("IReceta.php");
require_once("recetaDTO.php");
require_once(__DIR__ . "/../comun/baseDAO.php");
require_once("recetaAlreadyExistException.php");

class recetaDAO extends baseDAO implements IReceta
{
    public function __construct()
    {

    }

    private function buscarReceta($recetaId)
    {
        //Evita consultas que no sean string
        $escRecetaId = $this->realEscapeString($recetaId);

        //Conexion con la base de datos (Patron Singleton)
        $conn = getConexionBd();

        //Consulta
        $query = "SELECT * FROM recetas WHERE recetaId = ?";

        //Conecta con la base de datos
        $stmt = $conn->prepare($query);

        //Asocia %esRecetaName con el resultado
        $stmt->bind_param("i", $escRecetaId);

        //Ejecuta la consulta
        $stmt->execute();

        //Declaramos las variables para evitar error después
        $Id = $Nombre = $Autor = $Descripcion = $Pasos = $Tiempo = $Precio = $Fecha_Creacion = $Valoracion = null;

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

    public function crearReceta($recetaDTO)
    {
        $createdRecetaDTO = false;

        try
        {
            $conn = application::getInstance()->getConexionBd();

            $query = "INSERT INTO recetas (Nombre, Autor, Descripcion, Pasos, Tiempo, Precio, Fecha_Creacion, Valoracion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($query);

            if (!$stmt)
            {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            // Obtener valores del DTO y limpiar entradas para evitar inyección SQL
            $nombre = $recetaDTO->getNombre();
            $autor = $recetaDTO->getAutor();
            $descripcion = $recetaDTO->getDescripcion();
            $pasos =json_encode($recetaDTO->getPasos());
            $tiempo = $recetaDTO->getTiempo();
            $precio = $recetaDTO->getPrecio();
            $fechaCreacion = $recetaDTO->getFechaCreacion(); 
            $valoracion = $recetaDTO->getValoracion();

            //Definimos los tipos como int,string,string,string,string,int,decimal,string,decimal
            $stmt->bind_param("sissidsd", $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion);

            if ($stmt->execute())
            {
                $id = $conn->insert_id;

                $createdRecetaDTO = new recetaDTO($id, $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion);

                return $createdRecetaDTO;
            }
        }
        catch(mysqli_sql_exception $e)
        {
            throw $e;
        }

        return $createdRecetaDTO;
    }

    public function editarReceta($recetaDTO)
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
                $nombre = $recetaDTO->getNombre();
                $autor = $recetaDTO->getAutor();
                $descripcion = $recetaDTO->getDescripcion();
                $pasos = json_encode($recetaDTO->getPasos());
                $tiempo = $recetaDTO->getTiempo();
                $precio = $recetaDTO->getPrecio();
                $fechaCreacion = $recetaDTO->getFechaCreacion();
                $valoracion = $recetaDTO->getValoracion();
                $id = $recetaDTO->getId();

                $stmt->bind_param("ssssidsdi", $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion, $id);

                if ($stmt->execute()) {
                    $editedRecetaDTO = new recetaDTO(0, $nombre, $autor, $descripcion, json_decode($pasos, true), $tiempo, $precio, $fechaCreacion, $valoracion);
                }
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

    public function borrarReceta($recetaDTO)
    {
        $deletedRecetaDTO = false;

        try
        {
            $conn = application::getInstance()->getConexionBd();

            $query = "DELETE FROM recetas WHERE recetaId = ?";

            $stmt = $conn->prepare($query);

            $id = $recetaDTO->getId();

            $stmt->bind_param("i", $id);

            if ($stmt->execute())
            {
                $deletedRecetaDTO = $recetaDTO;
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

        return $deletedRecetaDTO;
    }

}
?>