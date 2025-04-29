<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};
use es\ucm\fdi\aw\entidades\ingredienteReceta\{ingredienteRecetaAppService};
use es\ucm\fdi\aw\entidades\etiquetaReceta\{etiquetaRecetaAppService};
use es\ucm\fdi\aw\comun\formularioBase;

// Clase editarRecetaForm para editar recetas existentes
class editarRecetaForm extends formularioBase
{
    private $recetaDTO;
    private $ingredientes;
    private $etiquetas; 
    
    // Constructor: Recibe el ID de la receta a editar y carga sus datos
    public function __construct() 
    {
        parent::__construct('editarRecetaForm', ['action' => '#']);
    }

    public function init($recetaId)
    {
        $recetaService = recetaAppService::GetSingleton();
        
        // Obtener la receta desde la base de datos
        $this->recetaDTO = $recetaService->buscarRecetaPorId(new recetaDTO($recetaId, null, null, null, null, null, null, null, null, null)); 

        //Hago lo mismo para obtener los ingredientes y las etiquetas
        $ingredienteRecetaService = ingredienteRecetaAppService::GetSingleton();
        $this->ingredientes = $ingredienteRecetaService->buscarIngredienteReceta($this->recetaDTO, 'ids');
    
        $etiquetaRecetaService = etiquetaRecetaAppService::GetSingleton();
        $this->etiquetas = $etiquetaRecetaService->buscarEtiquetaReceta($this->recetaDTO);
    }

    // Método para generar los campos del formulario con los datos actuales
    protected function CreateFields($datos)
    {
     
        $nombre = $this->recetaDTO->getNombre();
        $descripcion = $this->recetaDTO->getDescripcion();
        $rutaImagen = "img/receta/" . htmlspecialchars($this->recetaDTO->getRuta());     
        $precio = $this->recetaDTO->getPrecio();
        $tiempo = $this->recetaDTO->getTiempo();

        //Rellenamos los pasos de la receta
        $pasos = $this->recetaDTO->getPasos();
        $pasos = json_decode($pasos, true); // Convertir JSON en array       

        $stepsHtml = '';
        foreach ($pasos as $index => $paso) {
            $pasoSanitizado = htmlspecialchars($paso, ENT_QUOTES, 'UTF-8');
            $stepsHtml .= "<p class='step-item'><label>Paso " . ($index + 1) . ":</label> <textarea name='steps[]' required>$pasoSanitizado</textarea></p>";
        }    

        //Rellenamos los ingredientes de la receta
        $ingredientesArray = array_map(function($ingrediente) {
            return [
                'id' => $ingrediente->getIngrediente(), 
                'cantidad' => $ingrediente->getCantidad(), 
                'id_magnitud' => $ingrediente->getMagnitud()
            ];
        }, $this->ingredientes);        
        $ingredientesJSON = json_encode($ingredientesArray);

        //Rellenamos las etiquetas de la receta
        $etiquetasArray = array_map(function($etiqueta) {
            return [
                'id' => $etiqueta->getId(), 
                'nombre' => $etiqueta->getNombre(), 
            ];
        }, $this->etiquetas);        
        $etiquetasJSON = json_encode($etiquetasArray);


        // Generamos el formulario con los valores actuales para edición
        // Generación del HTML para el formulario
        $html = <<<EOF
            <div class="input-container">
                <input type="textarea" name="titulo" placeholder="TITULO" value="$nombre" required/>
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
                $stepsHtml
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
           <img src="$rutaImagen" alt="$nombre" class="receta-imagen-detalle">
            <input type="file" id="imagenReceta" name="imagenReceta" accept="image/jpeg, image/png, image/gif"/>

            <div id="previewContainer">
                <img id="previewImage" src="" alt="Vista previa de la imagen" style="display: none;"/>
            </div>

            <!-- Botones de acción -->
            <p>
                <button type="button" class="send-button" onclick="location.href='index.php'">CANCELAR</button>
                <button type="submit" class="send-button" name="guardar">GUARDAR</button>
                <button type="submit" class="send-button" name="borrar">BORRAR RECETA</button>

            </p>

            <!-- Mandamos los ingredientes y las etiquetas al JavaScript para que lo rellene -->
            <script>
                let ingredientesReceta = $ingredientesJSON;
                let etiquetasReceta = $etiquetasJSON;
            </script>           

            <!-- Importación de scripts JavaScript -->
            <script src="JS/editarReceta.js"></script>   
            <script src="JS/ingredientes.js"></script>
            <script src="JS/etiquetas.js"></script> 
        EOF;

        return $html;
    }

    // Método que maneja el procesamiento de la edición al enviar el formulario
    protected function Process($datos)
    {
        if (isset($datos['borrar'])) { // Si el formulario se envió con el botón "borrar"
            return $this->borrar($this->recetaDTO);
        }

        $result = array();
             
        // Saneamiento de datos de entrada
        $titulo = htmlspecialchars(trim($datos['titulo'] ?? ''), ENT_QUOTES, 'UTF-8');
        $descripcion = htmlspecialchars(trim($datos['descripcion'] ?? ''), ENT_QUOTES, 'UTF-8');
        $precio = isset($datos['precio']) ? floatval(trim($datos['precio'])) : 0;
        $tiempo = isset($datos['tiempo']) ? intval(trim($datos['tiempo'])) : 0;
        
        $ingredientesJson = $datos['ingredientesSeleccionados'] ?? '';
        $ingredientes = json_decode($ingredientesJson, true) ?? [];
        
        // Escapar cada paso individualmente
        $pasos = isset($datos['steps']) ? array_map(function ($paso) {
            return htmlspecialchars(trim($paso), ENT_QUOTES, 'UTF-8');
        }, $datos['steps']) : [];

        $etiquetas = isset($datos['etiquetas']) ? array_map('intval', explode(',', trim($datos['etiquetas']))) : [];
        $imagenGuardada = $this->procesarImagen($this->recetaDTO);


        // Validaciones
        if (empty($titulo) || empty($descripcion) || $precio <= 0 || $tiempo <= 0) {
            $result[] = "Error: Todos los campos son obligatorios y deben ser válidos.";
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
       

        // Si no hay errores, actualizar la receta
        if (count($result) === 0)
        {      
            // Crear un objeto DTO con los nuevos valores
            $recetaDTO = new recetaDTO($this->recetaDTO->getId(), $titulo, null, $descripcion, $pasos, $tiempo, $precio, null, null, $imagenGuardada);

            // Instancia del servicio de recetas
            $recetaService = recetaAppService::GetSingleton();
            $recetaService->editarReceta($recetaDTO, $ingredientes, $etiquetas);
            
            // Redirigir a la confirmación de actualización si tuvo éxito
            $result = 'confirmacionRecetaEditada.php';
        }

        return $result;
    }

    // Método para definir el encabezado de la página
    protected function Heading()
    {
        return '<h1>Editar Receta</h1>';
    }

    private function procesarImagen($recetaDTO)
    {
        //A implementar. Comprobar si se ha subido una imagen y de ser asi asegurarse de que se suba bien
        // Si no se ha subido ninguna imagen, asignamos la imagen por defecto
        if (!isset($_FILES['imagenReceta']) || $_FILES['imagenReceta']['error'] === UPLOAD_ERR_NO_FILE) {
            return $recetaDTO->getRuta(); // Retorna la imagen existente   
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

    public function borrar($recetaDTO) 
    {   
        // Lógica para borrar la receta
        $recetaService = recetaAppService::GetSingleton(); // Asegúrate de instanciar tu servicio de recetas
        $recetaService->borrarReceta($recetaDTO); // Llama al método para borrar la receta

        // Redirigir tras borrar
        header("Location: confirmacionRecetaBorrada.php");
        exit();
    }
}
