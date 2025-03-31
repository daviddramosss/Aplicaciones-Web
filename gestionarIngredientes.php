<?php
require_once("includes/config.php");
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDAO;
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDTO;

// Instanciar el objeto DAO
$ingredienteDAO = new IngredienteDAO();

// Si se solicita eliminar un ingrediente
if (isset($_POST['eliminar_id'])) {
    $idEliminar = $_POST['eliminar_id'];
    $ingredienteDTO = new IngredienteDTO($idEliminar, '');
    $ingredienteDAO->eliminarIngrediente($ingredienteDTO);
    header('Location: gestionarIngredientes.php'); // Evitar la reenvío de formulario
    exit;
}

// Si se solicita crear un nuevo ingrediente
if (isset($_POST['crear_nombre'])) {
    $nombre = $_POST['crear_nombre'];
    $ingredienteDTO = new IngredienteDTO(null, $nombre);
    $ingredienteDAO->crearIngrediente($ingredienteDTO);
    header('Location: gestionarIngredientes.php'); // Redirigir a la misma página
    exit;
}

// Si se solicita editar un ingrediente
if (isset($_POST['editar_id']) && isset($_POST['editar_nombre'])) {
    $idEditar = $_POST['editar_id'];
    $nombre = $_POST['editar_nombre'];
    $ingredienteDTO = new IngredienteDTO($idEditar, $nombre);
    $ingredienteDAO->editarIngrediente($ingredienteDTO);
    header('Location: gestionarIngredientes.php'); // Redirigir a la misma página
    exit;
}

// Obtener ingredientes
$ingredientes = $ingredienteDAO->obtenerIngredientes();

// Definir el contenido principal para la plantilla
$contenidoPrincipal = <<<EOS
    <h2>Panel de administración de ingredientes</h2>
    <p>En este panel puedes gestionar los ingredientes de la aplicación.</p>
    <p>Vas a poder borrar, crear o editar los ingredientes que quieras</p>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
EOS;

foreach ($ingredientes as $ingrediente) {
    $contenidoPrincipal .= "<tr>
        <td>" . htmlspecialchars($ingrediente['id']) . "</td>
        <td>" . htmlspecialchars($ingrediente['nombre']) . "</td>
        <td>
            <a href='editarIngrediente.php?id={$ingrediente['id']}'>✏️ Editar</a>
            <form action='gestionarIngredientes.php' method='POST' style='display:inline;'>
                <input type='hidden' name='eliminar_id' value='{$ingrediente['id']}'>
                <button type='submit'>🗑️ Eliminar</button>
            </form>
        </td>
    </tr>";
}

$contenidoPrincipal .= "</table>";

$contenidoPrincipal .= <<<EOS
    <h3>Crear Ingrediente</h3>
    <form method="POST" action="gestionarIngredientes.php">
        <label for="crear_nombre">Nombre del ingrediente:</label>
        <input type="text" id="crear_nombre" name="crear_nombre" required>
        <button type="submit">➕ Crear Ingrediente</button>
    </form>

    <h3>Editar Ingrediente</h3>
    <form method="POST" action="gestionarIngredientes.php">
        <label for="editar_id">ID del ingrediente:</label>
        <input type="number" id="editar_id" name="editar_id" required>
        <label for="editar_nombre">Nuevo nombre:</label>
        <input type="text" id="editar_nombre" name="editar_nombre" required>
        <button type="submit">✏️ Editar Ingrediente</button>
    </form>
EOS;

$tituloPagina = 'Gestionar Ingredientes';

// Se incluye la plantilla principal
require("includes/comun/plantilla.php");
?>
