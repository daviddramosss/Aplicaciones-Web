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
    public function buscarReceta($recetaId)
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();

        // Prepara la consulta SQL para buscar la receta
        $query = "SELECT * FROM recetas WHERE ID = ?";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Asocia el parámetro de la consulta con el valor del ID
        $stmt->bind_param("i", $recetaId);

        // Ejecuta la consulta
        if($stmt->execute())
        {
            // Declara las variables donde se almacenarán los resultados
            $Id = $Nombre = $Autor = $Descripcion = $Pasos = $Tiempo = $Precio = $Fecha_Creacion = $Valoracion = $ruta = null ;
            $stmt->bind_result($Id, $Nombre, $Autor, $Descripcion, $Pasos, $Tiempo, $Precio, $Fecha_Creacion, $Valoracion, $ruta);

            // Si se encontró la receta
            if ($stmt->fetch())
            {
                // Crea un objeto recetaDTO con los datos obtenidos
                $receta = new recetaDTO($Id, $Nombre, $Autor, $Descripcion, $Pasos, $Tiempo, $Precio, $Fecha_Creacion, $Valoracion, $ruta);
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
        $query = "INSERT INTO recetas (Nombre, Autor, Descripcion, Pasos, Tiempo, Precio, Fecha_Creacion, Valoracion, Ruta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
        $valoracion = $recetaDTO->getValoracion();
        $ruta = $recetaDTO->getRuta();

        // Asocia los parámetros de la consulta con los valores obtenidos
        $stmt->bind_param("sissidsds", $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion, $ruta);

        // Ejecuta la consulta
        if ($stmt->execute())
        {
            $id = $conn->insert_id;

            // Crea un DTO de receta con los datos insertados
            $createdRecetaDTO = new recetaDTO($id, $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion, $ruta);
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
        $query = "UPDATE recetas SET Nombre = ?, Autor = ?, Descripcion = ?, Pasos = ?, Tiempo = ?, Precio = ?, Fecha_Creacion = ?, Valoracion = ?, Ruta = ? WHERE Id = ?";

        // Prepara la declaración SQL
        $stmt = $conn->prepare($query);

        // Verifica si la receta existe antes de intentar editarla
        $recetaExiste = $this->buscarReceta($recetaDTO->getId());

        if($recetaExiste)
        {
            // Obtiene los datos de la receta del DTO
            $id = $recetaDTO->getId();
            $nombre = $recetaDTO->getNombre();
            $autor = $recetaDTO->getAutor();
            $descripcion = $recetaDTO->getDescripcion();
            $pasos = json_encode($recetaDTO->getPasos());
            $tiempo = $recetaDTO->getTiempo();
            $precio = $recetaDTO->getPrecio();
            $fechaCreacion = $recetaDTO->getFechaCreacion();
            $valoracion = $recetaDTO->getValoracion();
            $ruta = $recetaDTO->getRuta();

            // Asocia los parámetros de la consulta con los valores obtenidos
            $stmt->bind_param("sissidsdsi", $nombre, $autor, $descripcion, $pasos, $tiempo, $precio, $fechaCreacion, $valoracion, $ruta, $id);

            // Si la consulta se ejecuta correctamente, crea el DTO de la receta editada
            if ($stmt->execute()) {
                $editedRecetaDTO = new recetaDTO($id, $nombre, $autor, $descripcion, json_decode($pasos, true), $tiempo, $precio, $fechaCreacion, $valoracion, $ruta);
            }

            // Cierra la declaración
            // Usamos solo close, debido a que: Cierra el statement y libera todos los recursos asociados, por lo que usar un free sería innecesario.
            $stmt->close();
        }

        // Retorna el DTO de la receta editada
        return $editedRecetaDTO;
    }

    // Función pública para eliminar una receta de la base de datos
    public function borrarReceta($recetaId)
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
        $stmt->bind_param("i", $recetaId);

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

    public function mostarRecetasPorAutor($userDTO)
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
    
    // BUSQUEDA DINÁMICA para el buscador   
    public function busquedaDinamica($buscarPlato, $ordenar, $precioMin, $precioMax, $valoracion, $etiquetas)
    {
        $conn = application::getInstance()->getConexionBd();

        // Si no hay filtros, devuelve todas las recetas
        if ($buscarPlato == "" && $ordenar == "" && $precioMin == 0 && $precioMax == 100 && $valoracion == 0 && $etiquetas == "") {
            return $this->mostrarRecetas('todas');
        }

        // Consulta base
        $query = "SELECT ID, Nombre, Ruta FROM recetas WHERE Nombre LIKE ? AND Precio BETWEEN ? AND ? AND Valoracion >= ?";

        $params = [];
        $types = "siii"; // Nombre (string), PrecioMin (int), PrecioMax (int), Valoración (int)

        // Ajustar el nombre de búsqueda
        $buscarPlato = "%$buscarPlato%";
        $params[] = $buscarPlato;
        $params[] = $precioMin;
        $params[] = $precioMax;
        $params[] = $valoracion;

        // Filtrado por etiquetas (Si hay etiquetas)
        if ($etiquetas != "") {
            // Convertimos la lista de etiquetas a un array
            $etiquetasArray = explode(',', $etiquetas);
            $placeholders = implode(',', array_fill(0, count($etiquetasArray), '?'));

            $query .= " AND ID IN (SELECT Receta FROM receta_etiqueta WHERE Etiqueta IN ($placeholders))";

            foreach ($etiquetasArray as $etiqueta) {
                $params[] = trim($etiqueta);
                $types .= "s"; // Cada etiqueta es un string
            }
        }

        // Ordenamiento (Si se ha solicitado)
        if ($ordenar != "") {
            list($columna, $orden) = explode("_", $ordenar);
            $orden = strtoupper($orden); // Asegurar que sea ASC o DESC

            // Evitar SQL Injection validando columnas permitidas
            // $columnasPermitidas = ["Nombre", "Precio", "Valoracion"];
            // if (in_array($columna, $columnasPermitidas)) {
            $query .= " ORDER BY $columna $orden";
            // }
        }

        // Preparar la consulta
        $stmt = $conn->prepare($query);

        // Pasar los parámetros dinámicos
        $stmt->bind_param($types, ...$params);

        // Ejecutar consulta
        $stmt->execute();
        $result = $stmt->get_result();

        $recetas = [];
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
                    null,
                    $row["Ruta"]
                );
            }
        }

        $stmt->close();
        return $recetas;

    }

}  

?>