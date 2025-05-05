namespace es\ucm\fdi\aw\entidades\plato;

class PlatoAppService {
    private static $instance = null;
    private $dao;

    private function __construct() {
        $this->dao = new PlatoDAO();
    }

    public static function GetSingleton() {
        if (self::$instance == null) {
            self::$instance = new PlatoAppService();
        }
        return self::$instance;
    }

    public function obtenerPlatos() {
        return $this->dao->obtenerPlatos();
    }

    public function crearPlato($nombre, $descripcion) {
        $dto = new PlatoDTO(null, $nombre, $descripcion);
        $this->dao->crearPlato($dto);
    }

    public function editarPlato($id, $nombre, $descripcion) {
        $dto = new PlatoDTO($id, $nombre, $descripcion);
        $this->dao->editarPlato($dto);
    }

    public function eliminarPlato($id) {
        $dto = new PlatoDTO($id, '', '');
        $this->dao->eliminarPlato($dto);
    }

    public function obtenerIngredientesDePlato($idPlato) {
        return $this->dao->obtenerIngredientesDePlato($idPlato);
    }

    public function asociarIngrediente($idPlato, $idIngrediente) {
        $this->dao->asociarIngrediente($idPlato, $idIngrediente);
    }

    public function desasociarIngrediente($idPlato, $idIngrediente) {
        $this->dao->desasociarIngrediente($idPlato, $idIngrediente);
    }
}
