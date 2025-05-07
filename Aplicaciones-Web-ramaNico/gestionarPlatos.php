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
            <th>Acciones</th>
        </tr>
EOS;

foreach ($platos as $plato) {
    // Usando los métodos de la clase PlatoDTO para obtener los valores
    $contenidoPrincipal .= "<tr>
        <td>" . htmlspecialchars($plato->getId()) . "</td>
        <td>" . htmlspecialchars($plato->getNombre()) . "</td>
        <td>
            <form action='gestionarPlatos.php' method='POST' style='display:inline;' id='form_eliminar_{$plato->getId()}'>
                <input type='hidden' name='eliminar_id' value='" . htmlspecialchars($plato->getId()) . "'>
                <button type='button' onclick='confirmarEliminacion({$plato->getId()})'>🗑️ Eliminar</button>
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
        <button type="submit">➕ Crear Plato</button>
    </form>

    <h3>Editar Plato</h3>
    <form method="POST" action="gestionarPlatos.php">
        <label for="editar_id">ID del plato:</label>
        <input type="number" id="editar_id" name="editar_id" required>
        <label for="editar_nombre">Nuevo nombre:</label>
        <input type="text" id="editar_nombre" name="editar_nombre" required>
        <button type="submit">✏️ Editar Plato</button>
    </form>
EOS;

$tituloPagina = 'Gestionar Platos';
require("includes/comun/plantilla.php");
?>
