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
            if (isset($_POST['eliminar_id']) && is_numeric($_POST['eliminar_id'])) {
                $this->eliminarIngrediente((int)$_POST['eliminar_id']);
            } elseif (isset($_POST['crear_nombre']) && !empty(trim($_POST['crear_nombre']))) {
                $this->crearIngrediente(trim($_POST['crear_nombre']));
            } elseif (isset($_POST['editar_id'], $_POST['editar_nombre']) && is_numeric($_POST['editar_id']) && !empty(trim($_POST['editar_nombre']))) {
                $this->editarIngrediente((int)$_POST['editar_id'], trim($_POST['editar_nombre']));
            } else {
                $_SESSION['error'] = "Datos del formulario inválidos.";
                header('Location: gestionarIngredientes.php');
                exit;
            }
        }
    }

    private function eliminarIngrediente(int $id): void {
        $platos = $this->ingredienteDAO->obtenerPlatosPorIngrediente($id);
        if (empty($platos)) {
            $dto = new IngredienteDTO($id, null, true); // Permitir nombre vacío
            try {
                $this->ingredienteDAO->eliminarIngrediente($dto);
                $_SESSION['success'] = "Ingrediente eliminado correctamente.";
            } catch (\Exception $e) {
                $_SESSION['error'] = "Error al eliminar el ingrediente: " . htmlspecialchars($e->getMessage());
            }
        } else {
            $nombres = array_map(fn($p) => htmlspecialchars($p['nombre']), $platos);
            $_SESSION['error'] = "No se puede eliminar el ingrediente porque está en uso en los platos: " . implode(', ', $nombres);
        }
        header('Location: gestionarIngredientes.php');
        exit;
    }

    private function crearIngrediente(string $nombre): void {
        try {
            $dto = new IngredienteDTO(null, $nombre);
            $this->ingredienteDAO->crearIngrediente($dto);
            $_SESSION['success'] = "Ingrediente creado correctamente.";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al crear el ingrediente: " . htmlspecialchars($e->getMessage());
        }
        header('Location: gestionarIngredientes.php');
        exit;
    }

    private function editarIngrediente(int $id, string $nombre): void {
        try {
            $dto = new IngredienteDTO($id, $nombre);
            $this->ingredienteDAO->editarIngrediente($dto);
            $_SESSION['success'] = "Ingrediente editado correctamente.";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error al editar el ingrediente: " . htmlspecialchars($e->getMessage());
        }
        header('Location: gestionarIngredientes.php');
        exit;
    }

    public function obtenerTodos(): array {
        return $this->ingredienteDAO->obtenerIngredientes();
    }

    public function obtenerPlatosPorIngrediente(int $ingredienteId): array {
        return $this->ingredienteDAO->obtenerPlatosPorIngrediente($ingredienteId);
    }

    public function buscarIngredientes(string $busqueda): array {
        return $this->ingredienteDAO->buscarIngredientes(trim($busqueda));
    }

    public function renderizar(): string {
        $ingredientes = $this->obtenerTodos();
        $html = "<h2>Panel de administración de ingredientes</h2>\n";
        $html .= "<p>En este panel puedes gestionar los ingredientes de la aplicación.</p>\n";
        $html .= "<label for=\"busquedaIngrediente\">🔍 Buscar ingrediente:</label>\n";
        $html .= "<input type=\"text\" id=\"busquedaIngrediente\" placeholder=\"Escribe un nombre...\">\n";
        $html .= "<table border=\"1\">\n<thead><tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr></thead>\n<tbody id=\"cuerpoTabla\">\n";

        foreach ($ingredientes as $ing) {
            $id = htmlspecialchars($ing['id']);
            $nombre = htmlspecialchars($ing['nombre']);
            $platos = $this->obtenerPlatosPorIngrediente((int)$ing['id']);

            if (!empty($platos)) {
                $noms = array_map(fn($p) => htmlspecialchars($p['nombre']), $platos);
                $str = implode(', ', $noms);
                $html .= "<tr><td>{$id}</td><td>{$nombre}</td><td><button disabled>En uso: {$str}</button></td></tr>\n";
            } else {
                $html .= "<tr><td>{$id}</td><td>{$nombre}</td><td>";
                $html .= "<form id=\"form_eliminar_{$id}\" action=\"gestionarIngredientes.php\" method=\"POST\" style=\"display:inline;\">";
                $html .= "<input type=\"hidden\" name=\"eliminar_id\" value=\"{$id}\">";
                $html .= "<button type=\"button\" onclick=\"confirmarEliminacion({$id})\">🗑️ Eliminar</button>";
                $html .= "</form></td></tr>\n";
            }
        }

        $html .= "</tbody></table>\n";
        $html .= "<h3>Crear Ingrediente</h3>\n";
        $html .= "<form method=\"POST\" action=\"gestionarIngredientes.php\">";
        $html .= "<label for=\"crear_nombre\">Nombre:</label>";
        $html .= "<input type=\"text\" id=\"crear_nombre\" name=\"crear_nombre\" required>";
        $html .= "<button type=\"submit\">➕ Crear</button></form>\n";

        $html .= "<h3>Editar Ingrediente</h3>\n";
        $html .= "<form method=\"POST\" action=\"gestionarIngredientes.php\">";
        $html .= "<label for=\"editar_id\">ID:</label>";
        $html .= "<input type=\"number\" id=\"editar_id\" name=\"editar_id\" required>";
        $html .= "<label for=\"editar_nombre\">Nuevo nombre:</label>";
        $html .= "<input type=\"text\" id=\"editar_nombre\" name=\"editar_nombre\" required>";
        $html .= "<button type=\"submit\">✏️ Editar</button></form>\n";

        return $html;
    }
}