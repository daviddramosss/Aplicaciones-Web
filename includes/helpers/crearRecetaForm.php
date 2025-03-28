<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};
use es\ucm\fdi\aw\comun\formularioBase;
use es\ucm\fdi\aw\application;

// include_once __DIR__ . '/../comun/formularioBase.php';
// include_once __DIR__ . '/../entidades/receta/recetaAppService.php';

// Clase crearRecetaForm
class crearRecetaForm extends formularioBase
{
   // Constructor de la clase
    public function __construct() 
    {
        parent::__construct('crearRecetaForm');
    }

    // Método protegido que crea los campos del formulario 
    protected function CreateFields($datos)
    {
        // Recuperar valores previos o establecerlos vacíos
        $titulo = $datos['titulo'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $precio = $datos['precio'] ?? '';
        $tiempo = $datos['tiempo'] ?? '';

        // Generación del HTML para el formulario
        $html = <<<EOF
            <fieldset>                
                <p><label>Título:</label> <input type="text" name="titulo" value="$titulo" required/></p>
                
                <p><label>Descripción:</label> <textarea name="descripcion" required>$descripcion</textarea></p>
                
                <p><label>Precio Final:</label> <input type="number" step="0.1" name="precio" value="$precio" required/> <label>€</label></p>
                <p><label>Ingreso percibido estimado: <span id="ingresoEstimado">0</span> € (tras comisión MarketChef (15%))</label></p>

                <p><label>Tiempo de elaboración:</label> <input type="number" step="1" name="tiempo" value="$tiempo" required/> minutos</p>

                <!-- Sección de ingredientes -->
                <h2>Ingredientes</h2> 
                <div id="ingredientContainer">
                    <!-- Los ingredientes se insertarán dinámicamente con JavaScript -->
                </div>

                <!-- Sección de pasos -->
                <h2>Pasos para elaborar la receta</h2>
                <div id="stepsContainer">
                    <p><label>Paso 1:</label> <textarea name="steps[]" required></textarea></p>
                </div>
                <button type="button" class="btn-verde" id="addStep">+ Añadir paso</button>
                <button type="button" class="btn-rojo" id="removeStep">- Eliminar paso</button>
                
                <!-- Sección de etiquetas -->
                <h2>Etiquetas</h2>
                <p>Añade etiquetas para recomendar tu receta: (Máximo 3)</p>

                <div id="tagsContainer" class="tags-container">
                    <!-- Aquí se insertarán dinámicamente las etiquetas -->
                </div>

                <!-- Campo oculto para almacenar las etiquetas seleccionadas -->
                <input type="hidden" name="etiquetas" id="etiquetasSeleccionadas" value="">

                <div id="tagsContainer"></div>

                <!-- Sección de imagen -->
                <h2>Imagen de la receta</h2>
                <p><label>Sube una imagen de tu receta:</label> 
                    <input type="file" name="imagenReceta" accept="image/jpeg, image/png, image/gif" required/>
                </p>

                <!-- Botones de acción -->
                <p>
                    <button type="button" class="btn-rojo" onclick="location.href='index.php'">Cancelar</button>
                    <button type="submit" class="btn-verde" name="guardar">Guardar</button>
                </p>
            </fieldset>

            <!-- Importación de scripts JavaScript -->
            <script src="js/crearReceta.js"></script>    
            <script src="js/ingredientes.js"></script>
            <script src="js/etiquetas.js"></script> 
        EOF;

        return $html;
    }

    // Procesa la información del formulario una vez enviado.
    protected function Process($datos)
    {
        $result = array();

        // Obtener el usuario actual
        $application = application::getInstance();
        $usuarioId = $application->getIdUsuario();

        // Obtener la fecha de creación en formato adecuado
        $fecha_creacion = date('Y-m-d H:i:s');

        // Saneamiento de datos de entrada
        $titulo = filter_var(trim($datos['titulo'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $descripcion = filter_var(trim($datos['descripcion'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $precio = floatval($datos['precio'] ?? 0);
        $tiempo = floatval($datos['tiempo'] ?? 0);
        $ingredientes = $datos['ingredientes'] ?? [];
        $pasos = $datos['steps'] ?? [];

        // Int
        $etiquetas = isset($datos['etiquetas']) ? array_map('intval', explode(',', $datos['etiquetas'])) : [];


        // String
        //$etiquetas = isset($datos['etiquetas']) ? explode(',', $datos['etiquetas']) : [];


        // Validaciones de datos obligatorios
        if (empty($titulo) || empty($descripcion) || $precio <= 0 || $tiempo <= 0) {
            $result[] = "Error: Todos los campos son obligatorios y el precio debe ser mayor a 0.";
        }

        if (!is_array($ingredientes) || count($ingredientes) === 0) {
            $result[] = "Error: Debes añadir al menos un ingrediente.";
        }

        if (!is_array($pasos) || count($pasos) === 0) {
            $result[] = "Error: La receta debe tener al menos un paso.";
        }

        // Procesar la imagen
        $imagenGuardada = $this->procesarImagen();
        if ($imagenGuardada === null) {
            $result[] = "Error: La imagen subida no es válida.";
        }

        // Si no hay errores, proceder con la creación de la receta
        if (count($result) === 0)
        {
            try
            {
                // Crear el objeto DTO de receta con los datos ingresados
                $recetaDTO = new RecetaDTO(0, $titulo, $usuarioId, $descripcion, $pasos, $tiempo, $precio, $fecha_creacion, 0);

                // Instancia del servicio de recetas
                $recetaService = recetaAppService::GetSingleton();

                // Llamada al servicio para crear la receta
                $recetaCreadaDTO = $recetaService->crearReceta($recetaDTO, $ingredientes, $etiquetas);        

                // Redireccionar a la página principal si todo fue correcto
                $result = 'confirmacionRecetaCreada.php';
            }
            catch (recetaAlreadyExistException $e)
            {
                // Captura de excepción en caso de que la receta ya exista
                $result[] = $e->getMessage();
            }
        }

        return $result;
    }
    
    protected function Heading()
    {
        $html = '<h1>Nueva Receta</h1>';
        return $html;
    }

    protected function defineStyle()
    {
        $html= '<link rel="stylesheet" href="CSS/crearReceta.css">';
        return $html;
    }

    private function procesarImagen()
    {
        if (!isset($_FILES['imagenReceta']) || $_FILES['imagenReceta']['error'] !== UPLOAD_ERR_OK) {
            return null; // No se subió imagen o hubo un error
        }

        $imagenTmp = $_FILES['imagenReceta']['tmp_name'];
        $nombreOriginal = $_FILES['imagenReceta']['name'];
        
        // Generar un nombre único para evitar duplicados
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
        $nombreImagen = uniqid("receta_") . "." . $extension;
        
        $directorioDestino = __DIR__ . "/img/";

        // Validar formato de imagen (solo JPG, PNG, GIF)
        $formatosPermitidos = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $formatosPermitidos)) {
            return null; // Formato no permitido
        }

        // Guardar la imagen en el servidor
        $rutaFinal = $directorioDestino . $nombreImagen;
        if (!move_uploaded_file($imagenTmp, $rutaFinal)) {
            return null; // Error al guardar la imagen
        }

        return $nombreImagen; // Devolver el nombre de la imagen guardada
    }


}
?>
