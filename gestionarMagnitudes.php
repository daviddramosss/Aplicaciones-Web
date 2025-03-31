<?php
require_once("includes/config.php");
use es\ucm\fdi\aw\entidades\magnitudes\MagnitudesDAO;
use es\ucm\fdi\aw\entidades\magnitudes\MagnitudesDTO;

// Instanciar el objeto DAO
$magnitudesDAO = new MagnitudesDAO();

// Si se solicita eliminar una magnitud
if (isset($_POST['eliminar_id'])) {
    $idEliminar = $_POST['eliminar_id'];
    $magnitudesDTO = new MagnitudesDTO($idEliminar, '');
    $magnitudesDAO->eliminarMagnitud($magnitudesDTO);
    header('Location: gestionarMagnitudes.php'); // Evitar la reenvío de formulario
    exit;
}

// Si se solicita crear una nueva magnitud
if (isset($_POST['crear_nombre'])) {
    $nombre = $_POST['crear_nombre'];
    $magnitudesDTO = new MagnitudesDTO(null, $nombre);
    $magnitudesDAO->crearMagnitud($magnitudesDTO);
    header('Location: gestionarMagnitudes.php'); // Redirigir a la misma página
    exit;
}

// Si se solicita editar una magnitud
if (isset($_POST['editar_id']) && isset($_POST['editar_nombre'])) {
    $idEditar = $_POST['editar_id'];
    $nombre = $_POST['editar_nombre'];
    $magnitudesDTO = new MagnitudesDTO($idEditar, $nombre);
    $magnitudesDAO->editarMagnitud($magnitudesDTO);
    header('Location: gestionarMagnitudes.php'); // Redirigir a la misma página
    exit;
}

// Obtener magnitudes
$magnitudes = $magnitudesDAO->obtenerMagnitudes();

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
            <a href='editarMagnitud.php?id={$magnitud['id']}'>✏️ Editar</a>
            <form action='gestionarMagnitudes.php' method='POST' style='display:inline;'>
                <input type='hidden' name='eliminar_id' value='{$magnitud['id']}'>
                <button type='submit'>🗑️ Eliminar</button>
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
EOS;

$tituloPagina = 'Gestionar Magnitudes';

// Se incluye la plantilla principal
require("includes/comun/plantilla.php");
?>
