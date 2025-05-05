<?php
namespace es\ucm\fdi\aw\entidades\magnitudes;

require_once(__DIR__ . "/MagnitudDAO.php");
require_once(__DIR__ . "/MagnitudDTO.php");

class MagnitudAppService {
    private static $instance = null;
    private $magnitudDAO;

    private function __construct() {
        $this->magnitudDAO = new MagnitudDAO();
    }

    public static function GetSingleton() {
        if (self::$instance === null) {
            self::$instance = new MagnitudAppService();
        }
        return self::$instance;
    }

    public function obtenerMagnitudes() {
        return $this->magnitudDAO->obtenerMagnitudes();
    }

    public function crearMagnitud($nombre) {
        $magnitudDTO = new MagnitudDTO(null, $nombre);
        $this->magnitudDAO->crearMagnitud($magnitudDTO);
    }

    public function editarMagnitud($id, $nombre) {
        $magnitudDTO = new MagnitudDTO($id, $nombre);
        $this->magnitudDAO->editarMagnitud($magnitudDTO);
    }

    public function eliminarMagnitud($id) {
        $magnitudDTO = new MagnitudDTO($id, '');
        $this->magnitudDAO->eliminarMagnitud($magnitudDTO);
    }
}
?>
