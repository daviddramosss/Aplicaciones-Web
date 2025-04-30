<?php

require_once("../config.php");

use es\ucm\fdi\aw\application;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Cargamos los parámetros de la petición (si los hay)
    $buscarPlato = $_POST['buscarPlato'] ?? '';
    $ordenar = $_POST['ordenar'] ?? '';
    $precioMin = $_POST['precioMin'] ?? 0;
    $precioMax = $_POST['precioMax'] ?? 100;
    $etiquetas = $_POST['etiquetas'] ?? '';

    // Se obtiene la conexión a la base de datos a través de la aplicación
    $conn = application::getInstance()->getConexionBd();

    // Si no hay filtros, devuelve todas las recetas
    if ($buscarPlato == "" && $ordenar == "" && $precioMin == 0 && $precioMax == 100 && $etiquetas == "") {
        
        // Preparamos la sentencia para buscar todas las recetas
        $query = "SELECT ID, Nombre, Ruta FROM recetas";

        // Preparar la consulta
        $stmt = $conn->prepare($query);

        // Ejecutar consulta
        $stmt->execute();
        $result = $stmt->get_result();

        $recetas = obtenerRecetas($result);

        $stmt->close();
        // Devuelve todas las recetas
        echo json_encode(generaHTMLRecetas($recetas));
        exit;
    }

    // Preparamos la sentencia para buscar las recetas con los filtros propuestos
    $query = "SELECT ID, Nombre, Ruta FROM recetas WHERE Nombre LIKE ? AND Precio BETWEEN ? AND ? ";

    $params = [];
    $types = "sii"; // Nombre (string), PrecioMin (int), PrecioMax (int)

    // Ajustar el nombre de búsqueda por si viene de manera incompleta
    $buscarPlato = "%$buscarPlato%";
    $params[] = $buscarPlato;
    $params[] = $precioMin;
    $params[] = $precioMax;

    // Filtrado por etiquetas (Si hay etiquetas)
    if ($etiquetas != "") {
        // Convertimos la lista de etiquetas a un array
        $etiquetasArray = explode(',', $etiquetas);
        $placeholders = implode(',', array_fill(0, count($etiquetasArray), '?'));

        // Añadimos la condición de etiquetas a la consulta
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
        $query .= " ORDER BY $columna $orden";
    }

    // Preparar la consulta
    $stmt = $conn->prepare($query);

    // Pasar los parámetros dinámicos
    $stmt->bind_param($types, ...$params);

    // Ejecutar consulta
    $stmt->execute();
    $result = $stmt->get_result();

    $recetas = obtenerRecetas($result);
    
    $stmt->close();
    // Devuelve todas las recetas
    echo json_encode(generaHTMLRecetas($recetas));

}

// Función que genera el array de recetas en función del resultado de la consulta
function obtenerRecetas($result) {

    $recetas = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recetas[] = [
                "id" => $row["ID"], 
                "nombre" => $row["Nombre"],
                "ruta" => $row["Ruta"]
            ];
        }        
    }
    return $recetas;
}

// Función que genera el HTML de las recetas en función del array de recetas
function generaHTMLRecetas($recetas) {

    if (empty($recetas)) {
        return "<p>No existen recetas que cumplan esos criterios.</p>";
    }

    $html = '<div class="recetas-container">';
    
        foreach ($recetas as $receta) {
            $html .= <<<HTML
                <div class="receta-card">
                    <a href="mostrarReceta.php?id={$receta['id']}">
                        <img src="img/receta/{$receta['ruta']}" alt="{$receta['nombre']}" class="receta-imagen">
                    </a>
                    <p class="receta-titulo">{$receta['nombre']}</p>
                </div>
            HTML;
        }
    
        $html .= '</div>';
    
    return $html;
}

?>