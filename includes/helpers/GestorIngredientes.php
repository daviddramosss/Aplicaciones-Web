<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDAO;
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDTO;

class GestorIngredientes {
    private IngredienteDAO $ingredienteDAO;
    private array $ingredientes = [];
    private string $terminoBusqueda = '';
    private string $mensajeError = '';

    public function __construct() {
        $this->ingredienteDAO = new IngredienteDAO();
        $this->procesarFormulario(); // Esto puede dejar mensajeError
        $this->cargarIngredientes(); // Y luego cargar ingredientes normalmente
    }

    private function cargarIngredientes(): void {
        if (!empty($this->terminoBusqueda)) {
            $this->ingredientes = $this->ingredienteDAO->buscarIngredientesPorNombre($this->terminoBusqueda);
        } else {
            $this->ingredientes = $this->ingredienteDAO->obtenerIngredientes();
        }
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

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['busqueda'])) {
            $this->terminoBusqueda = trim($_GET['busqueda']);
        }
    }

    private function eliminarIngrediente($id): void {
        // Verificar si el ingrediente está asociado a algún plato
        $platos = $this->ingredienteDAO->obtenerPlatosPorIngrediente($id);

        if (!empty($platos)) {
            // Si el ingrediente está en uso, crear un mensaje con los nombres de los platos
            $nombres = array_map(fn($p) => $p['nombre'], $platos);
            $lista = implode(', ', array_map('htmlspecialchars', $nombres));
            $this->mensajeError = "No se puede eliminar el ingrediente porque está en uso en los siguientes platos: $lista.";
            return; // Evitar eliminar si está en uso
        }

        // Proceder con la eliminación si el ingrediente no está en uso
        $dto = new IngredienteDTO($id, '');
        try {
            $this->ingredienteDAO->eliminarIngrediente($dto);
            header('Location: gestionarIngredientes.php');
            exit;
        } catch (\Exception $e) {
            $this->mensajeError = "Error al eliminar ingrediente: " . htmlspecialchars($e->getMessage());
        }
    }

    private function crearIngrediente($nombre): void {
        $nombre = trim($nombre);
        if (!empty($nombre)) {
            $dto = new IngredienteDTO(null, $nombre);
            try {
                $this->ingredienteDAO->crearIngrediente($dto);
                header('Location: gestionarIngredientes.php');
                exit;
            } catch (\Exception $e) {
                $this->mensajeError = "Error al crear ingrediente: " . htmlspecialchars($e->getMessage());
            }
        }
    }

    private function editarIngrediente($id, $nombre): void {
        $nombre = trim($nombre);
        if (!empty($nombre)) {
            $dto = new IngredienteDTO($id, $nombre);
            try {
                $this->ingredienteDAO->editarIngrediente($dto);
                header('Location: gestionarIngredientes.php');
                exit;
            } catch (\Exception $e) {
                $this->mensajeError = "Error al editar ingrediente: " . htmlspecialchars($e->getMessage());
            }
        }
    }

    public function generarVista(): string {
        $html = <<<EOS
            <h2>Panel de administración de ingredientes</h2>
            <p>En este panel puedes gestionar los ingredientes de la aplicación.</p>
            <p>Puedes crear, editar o eliminar ingredientes.</p>
        EOS;

        if (!empty($this->mensajeError)) {
            $html .= "<div class='error'>" . htmlspecialchars($this->mensajeError) . "</div>";
        }

        $busqueda = htmlspecialchars($this->terminoBusqueda);
        $html .= <<<EOS
            <h3>Buscar Ingrediente</h3>
            <form method="GET" action="gestionarIngredientes.php" style="display:inline-block;">
                <label for="busqueda">Nombre del ingrediente:</label>
                <input type="text" id="busqueda" name="busqueda" value="{$busqueda}">
                <button type="submit">🔍 Buscar</button>
            </form>
            <form method="GET" action="gestionarIngredientes.php" style="display:inline-block; margin-left: 10px;">
                <button type="submit">🔄 Ver todos</button>
            </form>

            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
        EOS;

        foreach ($this->ingredientes as $ingrediente) {
            $id = htmlspecialchars($ingrediente['id']);
            $nombre = htmlspecialchars($ingrediente['nombre']);
            $html .= <<<EOS
                <tr>
                    <td>{$id}</td>
                    <td>{$nombre}</td>
                    <td>
            EOS;

            // Verificar si el ingrediente está asociado a algún plato
            $platos = $this->ingredienteDAO->obtenerPlatosPorIngrediente($id);
            if (!empty($platos)) {
                $nombres = array_map(fn($p) => $p['nombre'], $platos);
                $listaPlatos = implode(', ', array_map('htmlspecialchars', $nombres));
                $html .= "<span>Este ingrediente está en los siguientes platos: $listaPlatos</span>";
            } else {
                // Si no está asociado a ningún plato, mostrar botón de eliminar con confirmación
                $html .= <<<EOS
                    <form action="gestionarIngredientes.php" method="POST" style="display:inline;" id="form_eliminar_{$id}">
                        <input type="hidden" name="eliminar_id" value="{$id}">
                        <button type="button" onclick="confirmarEliminacion({$id})">🗑️ Eliminar</button>
                    </form>
                EOS;
            }

            $html .= "</td></tr>";
        }

        $html .= "</table>";

        $html .= <<<EOS
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
