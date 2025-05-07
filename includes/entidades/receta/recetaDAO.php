<?php

namespace es\ucm\fdi\aw\entidades\receta;

use es\ucm\fdi\aw\comun\baseDAO;
use es\ucm\fdi\aw\application;

// La clase recetaDAO hereda de baseDAO e implementa la interfaz IReceta
class recetaDAO extends baseDAO implements IReceta
{
    // Constructor vacío
    public function __construct()
    {
    }

    // Función privada para buscar una receta en la base de datos por su ID
    public function buscarReceta($recetaDTO)
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para buscar la receta
        $query = "SELECT * FROM recetas WHERE ID = ?";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el valor del ID
        $id = $recetaDTO->getId();
        $stmt->bind_param("i", $id);

        // Ejecuta la consulta
        if($stmt->execute())
        {
            // Declara las variables donde se almacenarán los resultados
            $Id = $Nombre = $Autor = $Descripcion = $Pasos = $Tiempo = $Precio = $Fecha_Creacion = $ruta = null ;
            $stmt->bind_result($Id, $Nombre, $Autor, $Descripcion, $Pasos, $Tiempo, $Precio, $Fecha_Creacion, $ruta);

            // Si se encontró la receta
            if ($stmt->fetch())
            {
                // Crea un objeto recetaDTO con los datos obtenidos
                $receta = new recetaDTO($Id, $Nombre, $Autor, $Descripcion, $Pasos, $Tiempo, $Precio, $Fecha_Creacion, $ruta);
                return $receta;
            }
            
            // Cierra la declaración
            // Usamos solo close, debido a que: Cierra el statement y libera todos los recursos asociados, por lo que usar un free sería innecesario.
            $stmt->close();
        }

        // Si no se encuentra la receta, retorna false
        return false;
    }

    // Función pública para crear una receta en la base de datos
    public function crearReceta($recetaDTO)
    {
        $createdRecetaDTO = false;

        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para insertar una receta
        $query = "INSERT INTO recetas (Nombre, Autor, Descripcion, Pasos, Tiempo, Precio, Fecha_Creacion, Ruta) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Obtiene los valores del DTO de receta y los limpia para evitar inyección SQL
        $nombre = $recetaDTO->getNombre();
        $autor = $recetaDTO->getAutor();
        $descripcion = $recetaDTO->getDescripcion();
        $pasos = json_encode($recetaDTO->getPasos()); // Convierte los pasos en JSON
        $tiempo = $recetaDTO->getTiempo();
        $precio = $recetaDTO->getPrecio();
        $fechaCreacion = $recetaDTO->getFechaCreacion(); 
        $ruta = $recetaDTO->getRuta();

        // Asocia los parámetros de la consulta con los valores obtenidos
        $stmt->bind_param("sissidss", $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $ruta);

        // Ejecuta la consulta
        if ($stmt->execute())
        {
            $id = $conn->insert_id;

            // Crea un DTO de receta con los datos insertados
            $createdRecetaDTO = new recetaDTO($id, $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $ruta);
            return $createdRecetaDTO;
        }

        // Cierra la declaración
        // Usamos solo close, debido a que: Cierra el statement y libera todos los recursos asociados, por lo que usar un free sería innecesario.
        $stmt->close();

        // Retorna false si algo sale mal
        return $createdRecetaDTO;
    }

    // Función pública para editar una receta existente
    public function editarReceta($recetaDTO)
    {
        $editedRecetaDTO = false;

        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para actualizar la receta
        $query = "UPDATE recetas SET Nombre = ?, Descripcion = ?, Pasos = ?, Tiempo = ?, Precio = ?, Ruta = ? WHERE Id = ?";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Verifica si la receta existe antes de intentar editarla
        $recetaExiste = $this->buscarReceta($recetaDTO);

        if($recetaExiste)
        {
            // Obtiene los datos de la receta del DTO
            $id = $recetaDTO->getId();
            $nombre = $recetaDTO->getNombre();
            $descripcion = $recetaDTO->getDescripcion();
            $pasos = json_encode($recetaDTO->getPasos());
            $tiempo = $recetaDTO->getTiempo();
            $precio = $recetaDTO->getPrecio();
            $ruta = $recetaDTO->getRuta();

            // Asocia los parámetros de la consulta con los valores obtenidos
            $stmt->bind_param("sssidsi", $nombre, $descripcion, $pasos, $tiempo, $precio, $ruta, $id);

            // Si la consulta se ejecuta correctamente, crea el DTO de la receta editada
            if ($stmt->execute()) {
                $editedRecetaDTO = new recetaDTO($id, $nombre, null, $descripcion, json_decode($pasos, true), $tiempo, $precio, null, $ruta);
            }

            // Cierra la declaración
            // Usamos solo close, debido a que: Cierra el statement y libera todos los recursos asociados, por lo que usar un free sería innecesario.
            $stmt->close();
        }

        // Retorna el DTO de la receta editada
        return $editedRecetaDTO;
    }

    // Función pública para eliminar una receta de la base de datos
    public function borrarReceta($recetaDTO)
    {
        $deletedRecetaDTO = false;

        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para eliminar la receta
        $query = "DELETE FROM recetas WHERE ID = ?";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el valor del ID
        //$id = $recetaDTO->getId();
        $stmt->bind_param("i", $recetaDTO->getId());

        // Si la consulta se ejecuta correctamente, retorna el DTO de la receta eliminada
        if ($stmt->execute())
        {
            $deletedRecetaDTO = true;
        }
        
        // Cierra la declaración
        // Usamos solo close, debido a que: Cierra el statement y libera todos los recursos asociados, por lo que usar un free sería innecesario.
        $stmt->close();

        // Retorna el DTO de la receta eliminada
        return $deletedRecetaDTO;
    }

    public function mostrarRecetasPorAutor($userDTO)
    {

        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para buscar la receta
        $query = "SELECT ID, Nombre, Ruta FROM recetas WHERE Autor = ?";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el ID de la receta
        $autor = $userDTO->getId();
        $stmt->bind_param("i", $autor);

        // Ejecuta la consulta
        if($stmt->execute())
        {
            // Obtiene el resultado de la consulta
            $result = $stmt->get_result();
            $recetas = [];

            // Si hay resultados, los recorremos y creamos DTOs de recetas
            if ($result->num_rows > 0) 
            {
                while ($row = $result->fetch_assoc()) 
                {
                    $recetas[] = new recetaDTO(
                        $row["ID"],
                        $row["Nombre"],
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        $row["Ruta"]
                    );
                }
            }
        }

        // Cierra la declaración
        // Usamos solo close, debido a que: Cierra el statement y libera todos los recursos asociados, por lo que usar un free sería innecesario.
        $stmt->close();

        return $recetas;
    }

    public function mostrarRecetas($criterio)
    {
        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        $ordenamiento = [
            'fecha' => "SELECT ID, Nombre, Ruta FROM recetas ORDER BY Fecha_Creacion DESC",
            'etiqueta_principal' => "SELECT r.ID, r.Nombre, r.Ruta FROM recetas r JOIN receta_etiqueta re ON r.ID = re.Receta 
                                    JOIN etiquetas e ON re.Etiqueta = e.ID WHERE e.Nombre = 'Principal'",
            'precio' => "SELECT ID, Nombre, Ruta FROM recetas ORDER BY Precio ASC",
            'ingrediente' => "SELECT r.ID, r.Nombre, r.Ruta, COUNT(ri.Ingrediente) AS num_ingredientes FROM recetas r 
                            LEFT JOIN receta_ingrediente ri ON r.ID = ri.Receta GROUP BY r.ID ORDER BY num_ingredientes DESC",
            'todas' => "SELECT ID, Nombre, Ruta FROM recetas"
        ];
        // Ordenamos por criterio y sino mostramos todos
        $query = $ordenamiento[$criterio] ?? $ordenamiento['todas'];

        $stmt = $conn->prepare($query);

        if($stmt->execute())
        {
            // Obtiene el resultado de la consulta
            $result = $stmt->get_result();
            $recetas = [];

            // Si hay resultados, los recorremos y creamos DTOs de recetas
            if ($result->num_rows > 0)  
            {
                while ($row = $result->fetch_assoc()) {
                    $recetas[] = new recetaDTO(
                        $row["ID"],
                        $row["Nombre"],
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        $row["Ruta"]
                    );
                }
            }
        }

        // Cierra la declaración
        // Usamos solo close, debido a que: Cierra el statement y libera todos los recursos asociados, por lo que usar un free sería innecesario.
        $stmt->close();

        return $recetas;

    }
    

    public function buscarRecetasConEtiquetas($etiquetas, $recetaDTO) // Recibimos un array de etiquetas
    {
        $recetas = [];
        $params = [];
        $types = "";
        $query = "";
        $html = "";

        // Obtiene la conexión a la base de datos
        $conn = application::getInstance()->getConexionBd();

        if (!empty($etiquetas)) {
         
            // Convertimos la lista de etiquetas a un array
            $placeholders = implode(',', array_fill(0, count($etiquetas), '?'));
            
            $id = $recetaDTO->getId();
            // Añadimos la condición de etiquetas a la consulta
            $query = "SELECT ID, Nombre, Ruta FROM recetas WHERE 1 AND ID IN (SELECT Receta FROM receta_etiqueta WHERE Etiqueta IN ($placeholders)) AND ID != $id ORDER BY RAND() LIMIT 4";
            
            foreach ($etiquetas as $etiqueta) {
                $params[] = $etiqueta->getId();
                $types .= "i"; // Comparando por número (Correcto si Etiqueta es un número)
            }


            // Preparar la consulta
            $stmt = $conn->prepare($query);
    
            // Pasar los parámetros dinámicos
            $stmt->bind_param($types, ...$params);
         
            // Ejecutar consulta
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recetas[] = new recetaDTO(
                        $row["ID"],
                        $row["Nombre"],
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        $row["Ruta"]
                    );
                }        
            }
    
            $stmt->close();
        }

          // Devuelve todas las recetas
        return $recetas;
    }

    public function esAutor($recetaDTO)
    {

        $autor = false;

         // Obtiene la conexión a la base de datos
         $conn = application::getInstance()->getConexionBd();

         // Prepara la consulta SQL para eliminar la receta
         $query = "SELECT 1 FROM recetas WHERE ID = ? AND Autor = ?";
 
         // Prepara la declaración SQL
         $stmt = $conn->prepare($query);
 
         // Asocia el parámetro de la consulta con el valor del ID
         //$id = $recetaDTO->getId();
         $recetaId = $recetaDTO->getId();
         $autor = $recetaDTO->getAutor();
         $stmt->bind_param("ii", $recetaId, $autor);

         // Ejecutar consulta
         $stmt->execute();
         $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            $autor = true;
        }

        $stmt->close();

        return $autor;
    }
}  


?>