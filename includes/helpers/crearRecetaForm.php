<?php

include_once __DIR__ . '/../comun/formularioBase.php';
include_once __DIR__ . '/../entidades/receta/recetaAppService.php';

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
                <legend><h1>Nueva Receta</h1></legend>
                
                <p><label>Título:</label> <input type="text" name="titulo" value="$titulo" required/></p>
                
                <p><label>Descripción:</label> <textarea name="descripcion" required>$descripcion</textarea></p>
                
                <p><label>Precio Final:</label> <input type="number" step="0.1" name="precio" value="$precio" required/> <label>€</label></p>
                <p><label>Ingreso percibido estimado: <span id="ingresoEstimado">0</span> € (tras comisión MarketChef (15%))</label></p>

                <p><label>Tiempo de elaboración:</label> <input type="number" step="1" name="tiempo" value="$tiempo" required/> minutos</p>

                <!-- Sección de ingredientes -->
                <p>
                    <h2>Ingredientes</h2> 
                    <button type="button" class="btn-verde" id="addIngredient">Añadir ingrediente</button>
                    <button type="button" class="btn-rojo" id="closeIngredientList">Cerrar lista ingredientes</button>
                </p>

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
                <input type="text" id="etiquetaInput" placeholder="Escribe una etiqueta..."/>
                <button type="button" class="btn-verde" id="addTag">+ Añadir etiqueta</button>
                
                <div id="tagsContainer"></div>

                <!-- Botones de acción -->
                <p>
                    <button type="button" class="btn-rojo" onclick="location.href='index.php'">Cancelar</button>
                    <button type="submit" class="btn-verde" name="guardar">Guardar</button>
                </p>
            </fieldset>

            <!-- Importación de scripts JavaScript -->
            <script src="js/crearReceta.js"></script>    
            <script src="js/ingredientes.js"></script> 
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
        $etiquetas = $datos['etiquetas'] ?? [];

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
    
}
?>
