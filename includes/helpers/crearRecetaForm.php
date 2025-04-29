<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};
use es\ucm\fdi\aw\entidades\ingredienteReceta\{ingredienteRecetaAppService, ingredienteRecetaDTO};
use es\ucm\fdi\aw\entidades\etiquetaReceta\{etiquetaRecetaAppService, etiquetaRecetaDTO};
use es\ucm\fdi\aw\comun\formularioBase;
use es\ucm\fdi\aw\application;

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
            <div class="input-container">
                <input type="textarea" name="titulo" placeholder="TITULO" value="$titulo" required/>
            </div>
            
            <div class="input-container">
                <input type="textarea" name="descripcion" placeholder="DESCRIPCION" value="$descripcion" required/>
            </div>
            
            <div class="input-container">
                <input type="number" step ="0.1" name="precio" placeholder="PRECIO EN €" value="$precio" required/>
            </div>
            <p>Ingreso percibido estimado: <span id="ingresoEstimado">0</span> € (tras comisión MarketChef (15%))</p>

            <div class="input-container">
                <input type="number" step ="1" name="tiempo" placeholder="TIEMPO DE ELABORACION EN MINUTOS" value="$tiempo" required/>
            </div>

            <!-- Sección de ingredientes -->
            <h2>Ingredientes</h2> 
            <div id="ingredientContainer">
                <!-- Los ingredientes se insertarán dinámicamente con JavaScript -->
            </div>
            <!-- Campo oculto para almacenar los ingredientes seleccionados -->
            <input type="hidden" name="ingredientesSeleccionados" id="ingredientesSeleccionadosInput" value="">


            <!-- Sección de pasos -->
            <h2>Pasos para elaborar la receta</h2>
            <div id="stepsContainer">
                <p class="step-item"><label>Paso 1:</label> <textarea name="steps[]" required></textarea></p>
            </div>

            <button type="button" class="send-button" id="addStep">+ AÑADIR PASO</button>
            <button type="button" class="send-button" id="removeStep">- ELIMINAR PASO</button>
            
            
            <!-- Sección de etiquetas -->
            <h2>Etiquetas</h2>
            <p>Añade etiquetas para recomendar tu receta: (Máximo 3)</p>

            <div id="tagsContainer" class="tags-container">
                <!-- Aquí se insertarán dinámicamente las etiquetas -->
            </div>

            <!-- Campo oculto para almacenar las etiquetas seleccionadas -->
            <input type="hidden" name="etiquetas" id="etiquetasSeleccionadas" value="">

            <!-- Sección de imagen -->
            <h2>Imagen de la receta</h2>
            <p><label for="imagenReceta">Sube una imagen de tu receta. Si no sube ninguna imagen, se usara la imagen por defecto.</label></p>
            <input type="file" id="imagenReceta" name="imagenReceta" accept="image/jpeg, image/png, image/gif"/>

            <div id="previewContainer">
                <img id="previewImage" src="" alt="Vista previa de la imagen" style="display: none;"/>
            </div>

            <!-- Botones de acción -->
            <p>
                <button type="button" class="send-button" onclick="location.href='index.php'">CANCELAR</button>
                <button type="submit" class="send-button" name="guardar">GUARDAR</button>
            </p>

            <!-- Importación de scripts JavaScript -->
            <script src="JS/crearReceta.js"></script>    
            <script src="JS/ingredientes.js"></script>
            <script src="JS/etiquetas.js"></script> 
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
        $titulo = trim($datos['titulo'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');
        $precio = isset($datos['precio']) ? floatval(trim($datos['precio'])) : 0;
        $tiempo = isset($datos['tiempo']) ? intval(trim($datos['tiempo'])) : 0;
        $ingredientesJson = $datos['ingredientesSeleccionados'] ?? '';
        $ingredientes = json_decode($ingredientesJson, true) ?? [];
        $pasos = isset($datos['steps']) ? array_map('trim', $datos['steps']) : [];
        $etiquetas = isset($datos['etiquetas']) ? array_map('intval', explode(',', trim($datos['etiquetas']))) : [];
        $imagenGuardada = $this->procesarImagen();


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
        if ($imagenGuardada === null) {
            $result[] = "Error: La imagen subida no es válida.";
        }

        // Si no hay errores, proceder con la creación de la receta
        if (count($result) === 0)
        {
             // Creación de la receta en la tabla recetas
            $recetaDTO = new RecetaDTO(0, $titulo, $usuarioId, $descripcion, $pasos, $tiempo, $precio, $fecha_creacion, 0, $imagenGuardada);
            $recetaService = recetaAppService::GetSingleton();
            $recetaService->crearReceta($recetaDTO, $ingredientes, $etiquetas);  
            
            // Redireccionar a la página principal si todo fue correcto
            $result = 'confirmacionRecetaCreada.php';
        }

        return $result;
    }
    
    protected function Heading()
    {
        $html = '<h1>Nueva Receta</h1>';
        return $html;
    }

    private function procesarImagen()
    {
        // Si no se ha subido ninguna imagen, asignamos la imagen por defecto
        if (!isset($_FILES['imagenReceta']) || $_FILES['imagenReceta']['error'] === UPLOAD_ERR_NO_FILE) {
            return "recetaDefault.jpeg";
        }
    
        // Comprobar si hubo un error al subir la imagen
        if ($_FILES['imagenReceta']['error'] !== UPLOAD_ERR_OK) {
            return null; // Error en la subida
        }
    
        $imagenTmp = $_FILES['imagenReceta']['tmp_name'];
        $nombreOriginal = $_FILES['imagenReceta']['name'];
    
        // Obtener la extensión del archivo
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
    
        // Validar formato de imagen (solo JPG, PNG, GIF)
        $formatosPermitidos = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $formatosPermitidos)) {
            return null; // Formato no permitido
        }
    
        // Generar un nombre único para evitar duplicados
        $nombreImagen = uniqid("receta_") . "." . $extension;
    
        // Definir la ruta de destino
        $directorioDestino = dirname(dirname(__DIR__)) . "/img/receta/";
    
        // Ruta completa donde se guardará la imagen
        $rutaFinal = $directorioDestino . $nombreImagen;
    
        // Guardar la imagen en el servidor
        if (!move_uploaded_file($imagenTmp, $rutaFinal)) {
            return null; // Error al guardar la imagen
        }
    
        return $nombreImagen; // Devolver el nombre de la imagen guardada
    }
    


}
?>
