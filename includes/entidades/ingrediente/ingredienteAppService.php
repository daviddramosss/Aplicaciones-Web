<?php
namespace es\ucm\fdi\aw\entidades\ingrediente;

use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDAO;
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDTO;

class IngredienteAppService {

    private static $instance = null;
    private $ingredienteDAO;

    private function __construct() {
        $this->ingredienteDAO = new IngredienteDAO();
    }

    public static function GetSingleton() {
        if (self::$instance == null) {
            self::$instance = new IngredienteAppService();
        }
        return self::$instance;
    }

    // Obtener todos los ingredientes
    public function obtenerIngredientes() {
        return $this->ingredienteDAO->obtenerIngredientes();
    }

    // Crear un ingrediente
    public function crearIngrediente($nombre) {
        $ingredienteDTO = new IngredienteDTO(null, $nombre);
        $this->ingredienteDAO->crearIngrediente($ingredienteDTO);
    }

    // Editar un ingrediente
    public function editarIngrediente($id, $nombre) {
        $ingredienteDTO = new IngredienteDTO($id, $nombre);
        $this->ingredienteDAO->editarIngrediente($ingredienteDTO);
    }

    // Eliminar un ingrediente
    public function eliminarIngrediente($id) {
        $ingredienteDTO = new IngredienteDTO($id, '');
        $this->ingredienteDAO->eliminarIngrediente($ingredienteDTO);
    }
}
?>
