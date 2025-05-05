namespace es\ucm\fdi\aw\entidades\plato;

use es\ucm\fdi\aw\application;
use es\ucm\fdi\aw\entidades\ingrediente\IngredienteDTO;

class PlatoDAO implements IPlato {
    public function crearPlato($dto) {
        $conn = application::getInstance()->getConexionBd();
        $query = "INSERT INTO platos (nombre, descripcion) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $dto->getNombre(), $dto->getDescripcion());
        $stmt->execute();
        $stmt->close();
    }

    public function editarPlato($dto) {
        $conn = application::getInstance()->getConexionBd();
        $query = "UPDATE platos SET nombre = ?, descripcion = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $dto->getNombre(), $dto->getDescripcion(), $dto->getId());
        $stmt->execute();
        $stmt->close();
    }

    public function eliminarPlato($dto) {
        $conn = application::getInstance()->getConexionBd();
        $query = "DELETE FROM platos WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $dto->getId());
        $stmt->execute();
        $stmt->close();
    }

    public function obtenerPlatos() {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT id, nombre, descripcion FROM platos";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $platos = [];
        while ($row = $result->fetch_assoc()) {
            $platos[] = new PlatoDTO($row['id'], $row['nombre'], $row['descripcion']);
        }
        $stmt->close();
        return $platos;
    }

    public function obtenerIngredientesDePlato($idPlato) {
        $conn = application::getInstance()->getConexionBd();
        $query = "SELECT i.id, i.nombre FROM ingredientes i
                  INNER JOIN plato_ingrediente pi ON pi.id_ingrediente = i.id
                  WHERE pi.id_plato = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idPlato);
        $stmt->execute();
        $result = $stmt->get_result();
        $ingredientes = [];
        while ($row = $result->fetch_assoc()) {
            $ingredientes[] = new IngredienteDTO($row['id'], $row['nombre']);
        }
        $stmt->close();
        return $ingredientes;
    }

    public function asociarIngrediente($idPlato, $idIngrediente) {
        $conn = application::getInstance()->getConexionBd();
        $query = "INSERT INTO plato_ingrediente (id_plato, id_ingrediente) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $idPlato, $idIngrediente);
        $stmt->execute();
        $stmt->close();
    }

    public function desasociarIngrediente($idPlato, $idIngrediente) {
        $conn = application::getInstance()->getConexionBd();
        $query = "DELETE FROM plato_ingrediente WHERE id_plato = ? AND id_ingrediente = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $idPlato, $idIngrediente);
        $stmt->execute();
        $stmt->close();
    }
}
