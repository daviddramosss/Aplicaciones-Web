<?php
// Incluir el archivo de configuración para establecer la conexión con la base de datos
require_once("includes/config.php");

// Importar las clases necesarias para gestionar los ingredientes
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDAO;
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDTO;

// Añadir el enlace a la hoja de estilos CSS
// Esto se usa para mantener el estilo de la interfaz de administración
echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';

// Crear una instancia del objeto DAO para interactuar con la base de datos
$ingredienteDAO = new IngredienteDAO();

// Verificar si se ha enviado una solicitud para eliminar un ingrediente
if (isset($_POST['eliminar_id'])) {
    $idEliminar = $_POST['eliminar_id'];
    $ingredienteDTO = new IngredienteDTO($idEliminar, ''); // Se crea un DTO con el ID
    $ingredienteDAO->eliminarIngrediente($ingredienteDTO); // Se solicita eliminar el ingrediente
    header('Location: gestionarIngredientes.php'); // Redirigir para evitar reenvíos accidentales del formulario
    exit;
}

// Verificar si se ha enviado una solicitud para crear un nuevo ingrediente
if (isset($_POST['crear_nombre'])) {
    $nombre = trim($_POST['crear_nombre']); // Se limpia el nombre ingresado
    if (!empty($nombre)) { // Se verifica que el nombre no esté vacío
        $ingredienteDTO = new IngredienteDTO(null, $nombre); // Se crea un DTO con el nuevo nombre
        try {
            $ingredienteDAO->crearIngrediente($ingredienteDTO); // Se guarda el nuevo ingrediente en la base de datos
        } catch (Exception $e) {
            echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
    header('Location: gestionarIngredientes.php');
    exit;
}

// Verificar si se ha enviado una solicitud para editar un ingrediente existente
if (isset($_POST['editar_id']) && isset($_POST['editar_nombre'])) {
    $idEditar = $_POST['editar_id'];
    $nombre = trim($_POST['editar_nombre']); // Se limpia el nombre ingresado
    if (!empty($nombre)) { // Se verifica que el nombre no esté vacío
        $ingredienteDTO = new IngredienteDTO($idEditar, $nombre); // Se crea un DTO con los nuevos datos
        try {
            $ingredienteDAO->editarIngrediente($ingredienteDTO); // Se actualiza el ingrediente en la base de datos
        } catch (Exception $e) {
            echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
    header('Location: gestionarIngredientes.php');
    exit;
}

// Obtener la lista de ingredientes almacenados en la base de datos
$ingredientes = $ingredienteDAO->obtenerIngredientes();

// Definir el contenido principal de la página de administración
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

// Generar dinámicamente la lista de ingredientes en una tabla HTML
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

// Formulario para crear un nuevo ingrediente
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

// Definir el título de la página
$tituloPagina = 'Gestionar Ingredientes';

// Incluir la plantilla principal de la aplicación
require("includes/comun/plantilla.php");
?>
