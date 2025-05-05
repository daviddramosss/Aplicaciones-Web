namespace es\ucm\fdi\aw\entidades\plato;

interface IPlato {
    public function crearPlato($platoDTO);
    public function editarPlato($platoDTO);
    public function eliminarPlato($platoDTO);
    public function obtenerPlatos();
    public function obtenerIngredientesDePlato($idPlato);
    public function asociarIngrediente($idPlato, $idIngrediente);
    public function desasociarIngrediente($idPlato, $idIngrediente);
}
