<?php
namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDAO;
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDTO;

class GestorIngredientes {
    private IngredienteDAO $ingredienteDAO;

    public function __construct() {
        $this->ingredienteDAO = new IngredienteDAO();
    }

    public function procesarFormulario(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['eliminar_id'])) {
                $this->eliminarIngrediente($_POST['eliminar_id']);
            } elseif (isset($_POST['crear_nombre'])) {
                $this->crearIngrediente($_POST['crear_nombre']);
            } elseif (isset($_POST['editar_id'], $_POST['editar_nombre'])) {
                $this->editarIngrediente($_POST['editar_id'], $_POST['editar_nombre']);
            }
        }
    }

    private function eliminarIngrediente($id): void {
        $platos = $this->ingredienteDAO->obtenerPlatosPorIngrediente($id);
        if (empty($platos)) {
            $dto = new IngredienteDTO($id, '');
            $this->ingredienteDAO->eliminarIngrediente($dto);
        } else {
            echo "<p style='color:red;'>No se puede eliminar el ingrediente porque está en uso en los siguientes platos: ";
            foreach ($platos as $plato) {
                echo htmlspecialchars($plato['nombre']) . ' ';
            }
            echo "</p>";
        }
        header('Location: gestionarIngredientes.php');
        exit;
    }

    private function crearIngrediente($nombre): void {
        $nombre = trim($nombre);
        if (!empty($nombre)) {
            $dto = new IngredienteDTO(null, $nombre);
            try {
                $this->ingredienteDAO->crearIngrediente($dto);
            } catch (\Exception $e) {
                echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        header('Location: gestionarIngredientes.php');
        exit;
    }

    private function editarIngrediente($id, $nombre): void {
        $nombre = trim($nombre);
        if (!empty($nombre)) {
            $dto = new IngredienteDTO($id, $nombre);
            try {
                $this->ingredienteDAO->editarIngrediente($dto);
            } catch (\Exception $e) {
                echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        header('Location: gestionarIngredientes.php');
        exit;
    }

    public function obtenerTodos(): array {
        return $this->ingredienteDAO->obtenerIngredientes();
    }

    public function obtenerPlatosPorIngrediente($ingredienteId) {
        return $this->ingredienteDAO->obtenerPlatosPorIngrediente($ingredienteId);
    }

    public function renderizar(): string {
        $ingredientes = $this->obtenerTodos();
    
        $html = <<<EOS
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
            $id = htmlspecialchars($ingrediente['id']);
            $nombre = htmlspecialchars($ingrediente['nombre']);
            $platosUsandoIngrediente = $this->obtenerPlatosPorIngrediente($ingrediente['id']);
    
            if (!empty($platosUsandoIngrediente)) {
                $platosNombres = array_map(function($plato) {
                    return htmlspecialchars($plato['nombre']);
                }, $platosUsandoIngrediente);
    
                $platosStr = implode(', ', $platosNombres);
                $html .= <<<EOS
                    <tr>
                        <td>$id</td>
                        <td>$nombre</td>
                        <td>
                            <button type='button' disabled>Este ingrediente está en los platos: $platosStr</button>
                        </td>
                    </tr>
                EOS;
            } else {
                $html .= <<<EOS
                    <tr>
                        <td>$id</td>
                        <td>$nombre</td>
                        <td>
                            <form action='gestionarIngredientes.php' method='POST' style='display:inline;' id='form_eliminar_$id'>
                                <input type='hidden' name='eliminar_id' value='$id'>
                                <button type='button' onclick='confirmarEliminacion($id)'>🗑️ Eliminar</button>
                            </form>
                        </td>
                    </tr>
                EOS;
            }
        }
    
        $html .= <<<EOS
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
    
        return $html;
    }
    
}
?>
