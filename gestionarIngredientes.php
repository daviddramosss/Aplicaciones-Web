<?php
require_once("includes/config.php");
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDAO;
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDTO;


// Añadir el enlace a la hoja de estilos CSS
echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';

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
    $nombre = trim($_POST['crear_nombre']);
    if (!empty($nombre)) {
        $ingredienteDTO = new IngredienteDTO(null, $nombre);
        try {
            $ingredienteDAO->crearIngrediente($ingredienteDTO);
        } catch (Exception $e) {
            echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
    header('Location: gestionarIngredientes.php');
    exit;
}

// Si se solicita editar un ingrediente
if (isset($_POST['editar_id']) && isset($_POST['editar_nombre'])) {
    $idEditar = $_POST['editar_id'];
    $nombre = trim($_POST['editar_nombre']);
    if (!empty($nombre)) {
        $ingredienteDTO = new IngredienteDTO($idEditar, $nombre);
        try {
            $ingredienteDAO->editarIngrediente($ingredienteDTO);
        } catch (Exception $e) {
            echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
    header('Location: gestionarIngredientes.php');
    exit;
}

// Obtener ingredientes
$ingredientes = $ingredienteDAO->obtenerIngredientes();

// Definir el contenido principal para la plantilla
$contenidoPrincipal = <<<EOS
    <h2>Panel de administración de ingredientes</h2>
    <p>En este panel puedes gestionar los ingredientes de la aplicación.</p>
    <p>Vas a poder borrar, crear o editar ingredientes.</p>

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
            <form action='gestionarIngredientes.php' method='POST' style='display:inline;' id='form_eliminar_{$ingrediente['id']}'>
                <input type='hidden' name='eliminar_id' value='" . htmlspecialchars($ingrediente['id']) . "'>
                <button type='button' onclick='confirmarEliminacion({$ingrediente['id']})'>🗑️ Eliminar</button>
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

    <script>
        function confirmarEliminacion(id) {
            // Mostrar una ventana de confirmación
            var respuesta = confirm("Estás a punto de eliminar un ingrediente. ¿Estás seguro?");
            if (respuesta) {
                // Si el usuario confirma, se envía el formulario correspondiente
                document.getElementById('form_eliminar_' + id).submit();
            }
        }
    </script>
EOS;

$tituloPagina = 'Gestionar Ingredientes';

// Se incluye la plantilla principal
require("includes/comun/plantilla.php");
?>
