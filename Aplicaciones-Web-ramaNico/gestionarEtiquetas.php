<?php
require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\GestorEtiquetas;

// Cargar estilos y scripts
echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';
echo '<script src="JS/gestiones.js"></script>';

// Crear instancia del helper y procesar formulario
$gestor = new GestorEtiquetas();
$gestor->procesarFormulario();

// Obtener etiquetas para mostrar
$etiquetas = $gestor->obtenerEtiquetas();

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
EOS;

$tituloPagina = 'Gestionar Etiquetas';

require("includes/comun/plantilla.php");
?>
