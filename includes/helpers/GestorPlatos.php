<?php
namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\plato\PlatoDAO;
use es\ucm\fdi\aw\entidades\plato\PlatoDTO;
if (!class_exists(\es\ucm\fdi\aw\entidades\plato\PlatoDAO::class)) {
        die("Clase PlatoDAO no se ha cargado. Verifica autoloader o ruta.");
    }
class GestorPlatos {
    
    
    private PlatoDAO $platoDAO;

    public function __construct() {
        $this->platoDAO = new PlatoDAO();
    }

    public function procesarFormulario(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['eliminar_id'])) {
                $this->eliminarPlato($_POST['eliminar_id']);
            } elseif (isset($_POST['crear_nombre'], $_POST['crear_descripcion'])) {
                $this->crearPlato($_POST['crear_nombre'], $_POST['crear_descripcion']);
            } elseif (isset($_POST['editar_id'], $_POST['editar_nombre'], $_POST['editar_descripcion'])) {
                $this->editarPlato($_POST['editar_id'], $_POST['editar_nombre'], $_POST['editar_descripcion']);
            }
        }
    }

    private function eliminarPlato($id): void {
        $dto = new PlatoDTO($id, '', '');
        $this->platoDAO->eliminarPlato($dto);
        header('Location: gestionarPlatos.php');
        exit;
    }

    private function crearPlato($nombre, $descripcion): void {
        $nombre = trim($nombre);
        $descripcion = trim($descripcion);
        if (!empty($nombre) && !empty($descripcion)) {
            $dto = new PlatoDTO(null, $nombre, $descripcion);
            try {
                $this->platoDAO->crearPlato($dto);
            } catch (\Exception $e) {
                echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        header('Location: gestionarPlatos.php');
        exit;
    }

    private function editarPlato($id, $nombre, $descripcion): void {
        $nombre = trim($nombre);
        $descripcion = trim($descripcion);
        if (!empty($nombre) && !empty($descripcion)) {
            $dto = new PlatoDTO($id, $nombre, $descripcion);
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
