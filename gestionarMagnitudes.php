<?php
// Incluir la configuración de la aplicación
require_once("includes/config.php");

// Importar las clases necesarias para manejar magnitudes
use es\ucm\fdi\aw\entidades\magnitudes\magnitudDAO;
use es\ucm\fdi\aw\entidades\magnitudes\magnitudDTO;

// Añadir el enlace a la hoja de estilos CSS
echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';

// Instanciar el objeto DAO para manejar magnitudes
$magnitudesDAO = new magnitudDAO();

// Procesar solicitud de eliminación de una magnitud
if (isset($_POST['eliminar_id'])) {
    $idEliminar = $_POST['eliminar_id'];
    $magnitudDTO = new magnitudDTO($idEliminar, ''); // Crear un DTO con el ID de la magnitud a eliminar
    $magnitudesDAO->borrarMagnitud($magnitudDTO); // Llamar a la función de eliminación
    header('Location: gestionarMagnitudes.php'); // Redirigir para evitar reenvíos
    exit;
}

// Procesar solicitud de creación de una nueva magnitud
if (isset($_POST['crear_nombre'])) {
    $nombre = $_POST['crear_nombre'];
    $magnitudDTO = new magnitudDTO(null, $nombre); // Crear DTO sin ID, ya que se generará en la BD
    $magnitudesDAO->crearMagnitud($magnitudDTO); // Llamar a la función para crear la magnitud
    header('Location: gestionarMagnitudes.php'); // Redirigir para actualizar la vista
    exit;
}

// Procesar solicitud de edición de una magnitud existente
if (isset($_POST['editar_id']) && isset($_POST['editar_nombre'])) {
    $idEditar = $_POST['editar_id'];
    $nombre = $_POST['editar_nombre'];
    $magnitudDTO = new magnitudDTO($idEditar, $nombre); // Crear DTO con la nueva información
    $magnitudesDAO->editarMagnitud($magnitudDTO); // Actualizar la magnitud en la BD
    header('Location: gestionarMagnitudes.php'); // Redirigir para reflejar cambios
    exit;
}

// Obtener la lista de magnitudes desde la base de datos
$magnitudes = $magnitudesDAO->mostrarMagnitudes();

// Definir el contenido principal de la página
$contenidoPrincipal = <<<EOS
    <h2>Panel de administración de magnitudes</h2>
    <p>En este panel puedes gestionar las magnitudes de la aplicación.</p>
    <p>Vas a poder borrar, crear o editar las magnitudes que quieras.</p>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
EOS;

// Generar filas de la tabla con las magnitudes existentes
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

// Formulario para crear una nueva magnitud
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

// Definir el título de la página
$tituloPagina = 'Gestionar Magnitudes';

// Incluir la plantilla principal para mostrar el contenido
require("includes/comun/plantilla.php");
?>
