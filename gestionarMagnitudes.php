<?php
require_once("includes/config.php");

use es\ucm\fdi\aw\entidades\magnitudes\magnitudDAO;
use es\ucm\fdi\aw\entidades\magnitudes\magnitudDTO;

// Añadir el enlace a la hoja de estilos CSS
echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';

// Instanciar el objeto DAO
$magnitudesDAO = new magnitudDAO();

// Si se solicita eliminar una magnitud
if (isset($_POST['eliminar_id'])) {
    $idEliminar = $_POST['eliminar_id'];
    $magnitudDTO = new magnitudDTO($idEliminar, '');
    $magnitudesDAO->borrarMagnitud($magnitudDTO);
    header('Location: gestionarMagnitudes.php');
    exit;
}

// Si se solicita crear una nueva magnitud
if (isset($_POST['crear_nombre'])) {
    $nombre = $_POST['crear_nombre'];
    $magnitudDTO = new magnitudDTO(null, $nombre);
    $magnitudesDAO->crearMagnitud($magnitudDTO);
    header('Location: gestionarMagnitudes.php');
    exit;
}

// Si se solicita editar una magnitud
if (isset($_POST['editar_id']) && isset($_POST['editar_nombre'])) {
    $idEditar = $_POST['editar_id'];
    $nombre = $_POST['editar_nombre'];
    $magnitudDTO = new magnitudDTO($idEditar, $nombre);
    $magnitudesDAO->editarMagnitud($magnitudDTO);
    header('Location: gestionarMagnitudes.php');
    exit;
}

// Obtener magnitudes
$magnitudes = $magnitudesDAO->mostrarMagnitudes();

// Definir el contenido principal para la plantilla
$contenidoPrincipal = <<<EOS
    <h2>Panel de administración de magnitudes</h2>
    <p>En este panel puedes gestionar las magnitudes de la aplicación.</p>
    <p>Vas a poder borrar, crear o editar las magnitudes que quieras</p>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
EOS;

foreach ($magnitudes as $magnitud) {
    $contenidoPrincipal .= "<tr>
        <td>" . htmlspecialchars($magnitud['id']) . "</td>
        <td>" . htmlspecialchars($magnitud['nombre']) . "</td>
        <td>
            <form action='gestionarMagnitudes.php' method='POST' style='display:inline;' id='form_eliminar_{$magnitud['id']}'>
                <input type='hidden' name='eliminar_id' value='{$magnitud['id']}'>
                <button type='button' onclick='confirmarEliminacion({$magnitud['id']})'>🗑️ Eliminar</button>
            </form>
        </td>
    </tr>";
}

$contenidoPrincipal .= "</table>";

$contenidoPrincipal .= <<<EOS
    <h3>Crear Magnitud</h3>
    <form method="POST" action="gestionarMagnitudes.php">
        <label for="crear_nombre">Nombre de la magnitud:</label>
        <input type="text" id="crear_nombre" name="crear_nombre" required>
        <button type="submit">➕ Crear Magnitud</button>
    </form>

    <h3>Editar Magnitud</h3>
    <form method="POST" action="gestionarMagnitudes.php">
        <label for="editar_id">ID de la magnitud:</label>
        <input type="number" id="editar_id" name="editar_id" required>
        <label for="editar_nombre">Nuevo nombre:</label>
        <input type="text" id="editar_nombre" name="editar_nombre" required>
        <button type="submit">✏️ Editar Magnitud</button>
    </form>

    <script>
        function confirmarEliminacion(id) {
            // Mostrar una ventana de confirmación
            var respuesta = confirm("Estás a punto de eliminar una magnitud. ¿Estás seguro?");
            if (respuesta) {
                // Si el usuario confirma, se envía el formulario correspondiente
                document.getElementById('form_eliminar_' + id).submit();
            }
        }
    </script>
EOS;

$tituloPagina = 'Gestionar Magnitudes';

// Se incluye la plantilla principal
require("includes/comun/plantilla.php");
?>
