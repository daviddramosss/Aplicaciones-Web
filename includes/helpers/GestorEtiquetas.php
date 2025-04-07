<?php
namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\etiquetas\etiquetasDAO;
use es\ucm\fdi\aw\entidades\etiquetas\etiquetasDTO;

class GestorEtiquetas {
    private $dao;

    public function __construct() {
        $this->dao = new etiquetasDAO();
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['eliminar_id'])) {
                $this->eliminarEtiqueta($_POST['eliminar_id']);
            }

            if (isset($_POST['crear_nombre'])) {
                $this->crearEtiqueta(trim($_POST['crear_nombre']));
            }

            if (isset($_POST['editar_id']) && isset($_POST['editar_nombre'])) {
                $this->editarEtiqueta($_POST['editar_id'], trim($_POST['editar_nombre']));
            }
        }
    }

    private function eliminarEtiqueta($id) {
        $dto = new etiquetasDTO($id, '');
        $this->dao->borrarEtiqueta($dto);
        header('Location: gestionarEtiquetas.php');
        exit;
    }

    private function crearEtiqueta($nombre) {
        if (!empty($nombre)) {
            $dto = new etiquetasDTO(null, $nombre);
            try {
                $this->dao->crearEtiqueta($dto);
            } catch (\Exception $e) {
                echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        header('Location: gestionarEtiquetas.php');
        exit;
    }

    private function editarEtiqueta($id, $nombre) {
        if (!empty($nombre)) {
            $dto = new etiquetasDTO($id, $nombre);
            try {
                $this->dao->editarEtiqueta($dto);
            } catch (\Exception $e) {
                echo "<p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        header('Location: gestionarEtiquetas.php');
        exit;
    }

    public function obtenerEtiquetas() {
        return $this->dao->obtenerEtiquetas();
    }
}
