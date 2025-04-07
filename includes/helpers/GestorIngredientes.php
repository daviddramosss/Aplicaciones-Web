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
        $dto = new IngredienteDTO($id, '');
        $this->ingredienteDAO->eliminarIngrediente($dto);
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
}
