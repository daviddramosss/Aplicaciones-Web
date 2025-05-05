<?php
require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\GestorPlatos;

echo '<link rel="stylesheet" type="text/css" href="css/gestionesAdmin.css">';
echo '<script src="JS/gestiones.js"></script>';

$gestor = new GestorPlatos();
$gestor->procesarFormulario();
$platos = $gestor->obtenerTodos();

$contenidoPrincipal = <<<EOS
    <h2>Panel de administración de platos</h2>
    <p>En este panel puedes gestionar los platos (recetas) de la aplicación.</p>
    <p>Vas a poder borrar, crear o editar platos.</p>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
EOS;

foreach ($platos as $plato) {
    $contenidoPrincipal .= "<tr>
        <td>" . htmlspecialchars($plato['id']) . "</td>
        <td>" . htmlspecialchars($plato['nombre']) . "</td>
        <td>" . htmlspecialchars($plato['descripcion']) . "</td>
        <td>
            <form action='gestionarPlatos.php' method='POST' style='display:inline;' id='form_eliminar_{$plato['id']}'>
                <input type='hidden' name='eliminar_id' value='" . htmlspecialchars($plato['id']) . "'>
                <button type='button' onclick='confirmarEliminacion({$plato['id']})'>🗑️ Eliminar</button>
            </form>
        </td>
    </tr>";
}

$contenidoPrincipal .= <<<EOS
    </table>

    <h3>Crear Plato</h3>
    <form method="POST" action="gestionarPlatos.php">
        <label for="crear_nombre">Nombre del plato:</label>
        <input type="text" id="crear_nombre" name="crear_nombre" required>
        <label for="crear_descripcion">Descripción del plato:</label>
        <textarea id="crear_descripcion" name="crear_descripcion" required></textarea>
        <button type="submit">➕ Crear Plato</button>
    </form>

    <h3>Editar Plato</h3>
    <form method="POST" action="gestionarPlatos.php">
        <label for="editar_id">ID del plato:</label>
        <input type="number" id="editar_id" name="editar_id" required>
        <label for="editar_nombre">Nuevo nombre:</label>
        <input type="text" id="editar_nombre" name="editar_nombre" required>
        <label for="editar_descripcion">Nueva descripción:</label>
        <textarea id="editar_descripcion" name="editar_descripcion" required></textarea>
        <button type="submit">✏️ Editar Plato</button>
    </form>
EOS;

$tituloPagina = 'Gestionar Platos';
require("includes/comun/plantilla.php");
