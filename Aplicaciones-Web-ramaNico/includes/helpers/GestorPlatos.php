<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\plato\PlatoDAO;
use es\ucm\fdi\aw\entidades\plato\PlatoDTO;

class GestorPlatos {

    private PlatoDAO $platoDAO;

    public function __construct() {
        $this->platoDAO = new PlatoDAO();
    }

    public function procesarFormulario(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['eliminar_id'])) {
                $this->eliminarPlato($_POST['eliminar_id']);
            } elseif (isset($_POST['crear_nombre'])) {
                $this->crearPlato($_POST['crear_nombre']);
            } elseif (isset($_POST['editar_id'], $_POST['editar_nombre'])) {
                $this->editarPlato($_POST['editar_id'], $_POST['editar_nombre']);
            }
        }
    }

    private function eliminarPlato($id): void {
        $dto = new PlatoDTO($id, '');
        $this->platoDAO->eliminarPlato($dto);
        header('Location: gestionarPlatos.php');
        exit;
    }

    private function crearPlato($nombre): void {
        $nombre = trim($nombre);
        if (!empty($nombre)) {
            $dto = new PlatoDTO(null, $nombre);
            try {
                $this->platoDAO->crearPlato($dto);
            } catch (\Exception $e) {
                echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        header('Location: gestionarPlatos.php');
        exit;
    }

    private function editarPlato($id, $nombre): void {
        $nombre = trim($nombre);
        if (!empty($nombre)) {
            $dto = new PlatoDTO($id, $nombre);
            try {
                $this->platoDAO->editarPlato($dto);
            } catch (\Exception $e) {
                echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        header('Location: gestionarPlatos.php');
        exit;
    }

    public function obtenerTodos(): array {
        return $this->platoDAO->obtenerPlatos();
    }
}
