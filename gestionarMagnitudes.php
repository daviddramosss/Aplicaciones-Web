<?php
require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\GestorMagnitudes;

// Cargar estilos y scripts
echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';
echo '<script src="JS/gestiones.js"></script>';

// Crear instancia del helper y procesar formulario
$gestor = new GestorMagnitudes();
$gestor->procesarFormulario();

// Obtener magnitudes para mostrar
$magnitudes = $gestor->obtenerMagnitudes();

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

foreach ($magnitudes as $magnitud) {
    $contenidoPrincipal .= "<tr>
        <td>" . htmlspecialchars($magnitud['id']) . "</td>
        <td>" . htmlspecialchars($magnitud['nombre']) . "</td>
        <td>
            <form action='gestionarMagnitudes.php' method='POST' style='display:inline;' id='form_eliminar_{$magnitud['id']}'>
                <input type='hidden' name='eliminar_id' value='" . htmlspecialchars($magnitud['id']) . "'>
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
EOS;

$tituloPagina = 'Gestionar Magnitudes';

require("includes/comun/plantilla.php");
?>
