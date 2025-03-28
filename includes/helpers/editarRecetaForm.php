<?php
//ESQUELETO E IMPLEMENTACION INICIAL. TIENE FALLOS
namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};
use es\ucm\fdi\aw\comun\formularioBase;
use es\ucm\fdi\aw\application;

// Clase editarRecetaForm para editar recetas existentes
class editarRecetaForm extends formularioBase
{
    private $receta;
    
    // Constructor: Recibe el ID de la receta a editar y carga sus datos
    public function __construct($recetaId) 
    {
        parent::__construct('editarRecetaForm');
        
        // Obtener instancia del servicio de recetas
        $recetaService = recetaAppService::GetSingleton();
        
        // Obtener la receta desde la base de datos
        $this->receta = $recetaService->obtenerRecetaPorId($recetaId);
    }

    // Método para generar los campos del formulario con los datos actuales
    protected function CreateFields($datos)
    {
        // Si ya hay datos en el formulario (tras un intento fallido de envío), se usan esos. Si no, se usan los valores actuales de la receta.
        $titulo = $datos['titulo'] ?? $this->receta->getTitulo();
        $descripcion = $datos['descripcion'] ?? $this->receta->getDescripcion();
        $precio = $datos['precio'] ?? $this->receta->getPrecio();
        $tiempo = $datos['tiempo'] ?? $this->receta->getTiempo();

        // Generamos el formulario con los valores actuales para edición
        $html = <<<EOF
                <div class="input-container"><input type="text" name="titulo" value="$titulo" required/></div>
                <div class="input-container"><textarea name="descripcion" required>$descripcion</textarea></div>
                <div class="input-container"><input type="number" step="0.1" name="precio" value="$precio" required/></div>
                <div class="input-container"><input type="number" step="1" name="tiempo" value="$tiempo" required/></div>
                
                <p>
                    <button type="button" class="send-button" onclick="location.href='index.php'">CANCELAR</button>
                    <button type="submit" class="send-button" name="guardar">GUARDAR CAMBIOS</button>
                </p>
            EOF;

        return $html;
    }

    // Método que maneja el procesamiento de la edición al enviar el formulario
    protected function Process($datos)
    {
        $result = array();

        // Obtener el usuario actual
        $application = application::getInstance();
        $usuarioId = $application->getIdUsuario();

        // Sanitizar y validar los datos recibidos
        $titulo = filter_var(trim($datos['titulo'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $descripcion = filter_var(trim($datos['descripcion'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $precio = floatval($datos['precio'] ?? 0);
        $tiempo = intval($datos['tiempo'] ?? 0);

        // Validaciones
        if (empty($titulo) || empty($descripcion) || $precio <= 0 || $tiempo <= 0) {
            $result[] = "Error: Todos los campos son obligatorios y deben ser válidos.";
        }

        // Si no hay errores, actualizar la receta
        if (count($result) === 0)
        {
            try
            {
                // Crear un objeto DTO con los nuevos valores
                $recetaDTO = new recetaDTO($this->receta->getId(), $titulo, $usuarioId, $descripcion, [], $tiempo, $precio, $this->receta->getFechaCreacion(), $this->receta->getValoracion(), $this->receta->getImagen());

                // Obtener el servicio y actualizar la receta
                $recetaService = recetaAppService::GetSingleton();
                $recetaService->actualizarReceta($recetaDTO);

                // Redirigir a la confirmación de actualización
                $result = 'confirmacionRecetaEditada.php';
            }
            catch (Exception $e)
            {
                $result[] = "Error al actualizar la receta: " . $e->getMessage();
            }
        }

        return $result;
    }

    // Método para definir el encabezado de la página
    protected function Heading()
    {
        return '<h1>Editar Receta</h1>';
    }
}
