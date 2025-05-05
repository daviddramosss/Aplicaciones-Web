<?php
namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\magnitudes\magnitudDAO;
use es\ucm\fdi\aw\entidades\magnitudes\magnitudDTO;

class GestorMagnitudes {
    private $dao;

    public function __construct() {
        $this->dao = new magnitudDAO();
    }

    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['eliminar_id'])) {
                $this->eliminarMagnitud($_POST['eliminar_id']);
            }

            if (isset($_POST['crear_nombre'])) {
                $this->crearMagnitud(trim($_POST['crear_nombre']));
            }

            if (isset($_POST['editar_id']) && isset($_POST['editar_nombre'])) {
                $this->editarMagnitud($_POST['editar_id'], trim($_POST['editar_nombre']));
            }
        }
    }

    private function eliminarMagnitud($id) {
        $dto = new magnitudDTO($id, '');
        $this->dao->borrarMagnitud($dto);
        header('Location: gestionarMagnitudes.php');
        exit;
    }

    private function crearMagnitud($nombre) {
        if (!empty($nombre)) {
            $dto = new magnitudDTO(null, $nombre);
            $this->dao->crearMagnitud($dto);
        }
        header('Location: gestionarMagnitudes.php');
        exit;
    }

    private function editarMagnitud($id, $nombre) {
        if (!empty($nombre)) {
            $dto = new magnitudDTO($id, $nombre);
            $this->dao->editarMagnitud($dto);
        }
        header('Location: gestionarMagnitudes.php');
        exit;
    }

    public function obtenerMagnitudes() {
        return $this->dao->mostrarMagnitudes();
    }
}
