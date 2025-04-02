<?php
// Incluir el archivo de configuración
require_once("includes/config.php");

// Importar las clases necesarias para la gestión de etiquetas
use es\ucm\fdi\aw\entidades\etiquetas\etiquetasDAO;
use es\ucm\fdi\aw\entidades\etiquetas\etiquetasDTO;

// Añadir el enlace a la hoja de estilos CSS para mejorar la apariencia
echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';

// Instanciar el objeto DAO para manejar las etiquetas en la base de datos
$etiquetasDAO = new etiquetasDAO();

// Si se solicita eliminar una etiqueta
if (isset($_POST['eliminar_id'])) {
    $idEliminar = $_POST['eliminar_id'];
    $etiquetasDTO = new etiquetasDTO($idEliminar, '');
    $etiquetasDAO->borrarEtiqueta($etiquetasDTO);
    header('Location: gestionarEtiquetas.php'); // Evitar el reenvío del formulario
    exit;
}

// Si se solicita crear una nueva etiqueta
if (isset($_POST['crear_nombre'])) {
    $nombre = trim($_POST['crear_nombre']);
    if (!empty($nombre)) {
        $etiquetasDTO = new etiquetasDTO(null, $nombre);
        try {
            $etiquetasDAO->crearEtiqueta($etiquetasDTO);
        } catch (Exception $e) {
            echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
    header('Location: gestionarEtiquetas.php');
    exit;
}

// Si se solicita editar una etiqueta
if (isset($_POST['editar_id']) && isset($_POST['editar_nombre'])) {
    $idEditar = $_POST['editar_id'];
    $nombre = trim($_POST['editar_nombre']);
    if (!empty($nombre)) {
        $etiquetasDTO = new etiquetasDTO($idEditar, $nombre);
        try {
            $etiquetasDAO->editarEtiqueta($etiquetasDTO);
        } catch (Exception $e) {
            echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
    header('Location: gestionarEtiquetas.php');
    exit;
}

// Obtener la lista de etiquetas desde la base de datos
$etiquetas = $etiquetasDAO->obtenerEtiquetas();

// Definir el contenido principal para la plantilla
$contenidoPrincipal = <<<EOS
    <h2>Panel de administración de etiquetas</h2>
    <p>En este panel puedes gestionar las etiquetas de la aplicación.</p>
    <p>Vas a poder borrar, crear o editar etiquetas.</p>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
EOS;

// Generar filas de la tabla con los datos de las etiquetas
foreach ($etiquetas as $etiqueta) {
    $contenidoPrincipal .= "<tr>
        <td>" . htmlspecialchars($etiqueta['id']) . "</td>
        <td>" . htmlspecialchars($etiqueta['nombre']) . "</td>
        <td>
            <form action='gestionarEtiquetas.php' method='POST' style='display:inline;' id='form_eliminar_{$etiqueta['id']}'>
                <input type='hidden' name='eliminar_id' value='" . htmlspecialchars($etiqueta['id']) . "'>
                <button type='button' onclick='confirmarEliminacion({$etiqueta['id']})'>🗑️ Eliminar</button>
            </form>
        </td>
    </tr>";
}

$contenidoPrincipal .= "</table>";

// Formulario para crear una nueva etiqueta
$contenidoPrincipal .= <<<EOS
    <h3>Crear Etiqueta</h3>
    <form method="POST" action="gestionarEtiquetas.php">
        <label for="crear_nombre">Nombre de la etiqueta:</label>
        <input type="text" id="crear_nombre" name="crear_nombre" required>
        <button type="submit">➕ Crear Etiqueta</button>
    </form>

    <h3>Editar Etiqueta</h3>
    <form method="POST" action="gestionarEtiquetas.php">
        <label for="editar_id">ID de la etiqueta:</label>
        <input type="number" id="editar_id" name="editar_id" required>
        <label for="editar_nombre">Nuevo nombre:</label>
        <input type="text" id="editar_nombre" name="editar_nombre" required>
        <button type="submit">✏️ Editar Etiqueta</button>
    </form>

    <script>
        function confirmarEliminacion(id) {
            // Mostrar una ventana de confirmación
            var respuesta = confirm("Estás a punto de eliminar una etiqueta. ¿Estás seguro?");
            if (respuesta) {
                // Si el usuario confirma, se envía el formulario correspondiente
                document.getElementById('form_eliminar_' + id).submit();
            }
        }
    </script>
EOS;

// Definir el título de la página
$tituloPagina = 'Gestionar Etiquetas';

// Incluir la plantilla principal
require("includes/comun/plantilla.php");
?>