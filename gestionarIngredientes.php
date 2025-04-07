<?php
require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\GestorIngredientes;

echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';
echo '<script src="JS/gestiones.js"></script>';

$gestor = new GestorIngredientes();
$gestor->procesarFormulario();
$ingredientes = $gestor->obtenerTodos();

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

$contenidoPrincipal .= <<<EOS
    </table>

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
require("includes/comun/plantilla.php");
