<?php
//ESQUELETO E IMPLEMENTACION INICIAL. TIENE FALLOS
namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};
use es\ucm\fdi\aw\entidades\ingredienteReceta\{ingredienteRecetaAppService, ingredienteRecetaDTO};
use es\ucm\fdi\aw\entidades\etiquetaReceta\{etiquetaRecetaAppService, etiquetaRecetaDTO};
use es\ucm\fdi\aw\comun\formularioBase;
use es\ucm\fdi\aw\application;

// Clase editarRecetaForm para editar recetas existentes
class editarRecetaForm extends formularioBase
{
    private $receta;

    private $ingredientes;
    private $etiquetas; 
    private $id; 
    
    // Constructor: Recibe el ID de la receta a editar y carga sus datos
    public function __construct($recetaId) 
    {
       // parent::__construct('editarRecetaForm');

        
        // Obtener instancia del servicio de recetas
        $recetaService = recetaAppService::GetSingleton();
        
        // Obtener la receta desde la base de datos
        $this->receta = $recetaService->buscarRecetaPorId($recetaId); 

        //Hago lo mismo para obtener los ingredientes y las etiquetas
        $ingredienteRecetaService = ingredienteRecetaAppService::GetSingleton();
        $this->ingredientes = $ingredienteRecetaService->buscarIngredienteReceta($recetaId);
    
        $etiquetaRecetaService = etiquetaRecetaAppService::GetSingleton();
        $this->etiquetas = $etiquetaRecetaService->buscarEtiquetaReceta($recetaId);
    }

    // Método para generar los campos del formulario con los datos actuales
    protected function CreateFields($datos)
    {
     
        $nombre = $this->receta->getNombre();
        $descripcion = $this->receta->getDescripcion();
        $rutaImagen = "img/receta/" . htmlspecialchars($this->receta->getRuta());
        //$ingredientes = DAOIngrediente::buscarPorReceta($this->receta->getId());
     
        $precio = $this->receta->getPrecio();
        $tiempo = $this->receta->getTiempo();

        /*
        $pasos = json_decode($this->receta->getPasos(), true); // Decodificar JSON
        $pasosJSON = json_encode($pasos); // Convertir a JSON para JavaScript 
        $html = <<<EOF
            <script>
                let pasosGuardados = $pasosJSON;
            </script>
                                   
        EOF;
        */

        //Añadido por Antonio
        $pasos = $this->receta->getPasos();
        $pasos = json_decode($pasos, true); // Convertir JSON en array

       

        $stepsHtml = '';
        foreach ($pasos as $index => $paso) {
            $pasoSanitizado = htmlspecialchars($paso, ENT_QUOTES, 'UTF-8');
            $stepsHtml .= "<p class='step-item'><label>Paso " . ($index + 1) . ":</label> <textarea name='steps[]' required>$pasoSanitizado</textarea></p>";
        }    


        $ingredientesArray = array_map(function($ingrediente) {
            return [
                'id' => $ingrediente['ID'],  // Convertimos "ID" a "id"
                'nombre' => $ingrediente['Ingrediente'], // Convertimos "Ingrediente" a "nombre"
                'cantidad' => $ingrediente['Cantidad'], // Ya coincide
                'magnitud' => $ingrediente['Magnitud'], // Ya coincide
                'id_magnitud' => $ingrediente['ID_Magnitud']
            ];
        }, $this->ingredientes);
        
        $ingredientesJSON = json_encode($ingredientesArray);


        // Generamos el formulario con los valores actuales para edición
       // Generación del HTML para el formulario
       $html = <<<EOF
            <input type="hidden" name="id" value="{$this->receta->getId()}">

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
                <button type="submit" class="send-button" name="eliminar">BORRAR RECETA</button>
            </p>

            <script>
                let ingredientesReceta = $ingredientesJSON;
            </script>

           

            <!-- Importación de scripts JavaScript -->
            <script src="js/editarReceta.js"></script>   
            <script src="js/ingredientes.js"></script>
            <script src="js/etiquetas.js"></script> 
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
        $id = intval($datos['id'] ?? 0);

        // Obtener instancia del servicio de recetas
        $recetaService = recetaAppService::GetSingleton();
        // Obtener la receta desde la base de datos
        $recetaID = $recetaService->buscarRecetaPorId($id); 
 
        
        $titulo = filter_var(trim($datos['titulo'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $descripcion = filter_var(trim($datos['descripcion'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $precio = floatval($datos['precio'] ?? 0);
        $tiempo = intval($datos['tiempo'] ?? 0);
        $ingredientes = $datos['ingredientes'] ?? [];
        $pasos = $datos['steps'] ?? [];
        $etiquetas = isset($datos['etiquetas']) ? array_map('intval', explode(',', $datos['etiquetas'])) : [];
        $imagenGuardada = $this->procesarImagen($recetaID); 



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
                $recetaDTO = new recetaDTO($recetaID->getId(), $titulo, $usuarioId, $descripcion, $pasos, $tiempo, $precio, $recetaID->getFechaCreacion(), $recetaID->getValoracion(), $imagenGuardada);

               // Instancia del servicio de recetas
                $recetaService = recetaAppService::GetSingleton();

                // Llamada al servicio para editar la receta
                $recetaService->editarReceta($recetaDTO, $ingredientes, $etiquetas);  

                // Redirigir a la confirmación de actualización si tuvo éxito
                header("Location: confirmacionRecetaEditada.php");
                exit();
        }

        return $result;
    }

    // Método para definir el encabezado de la página
    protected function Heading()
    {
        return '<h1>Editar Receta</h1>';
    }

    private function procesarImagen($recetaID)
    {
        //A implementar. Comprobar si se ha subido una imagen y de ser asi asegurarse de que se suba bien
         // Si no se ha subido ninguna imagen, asignamos la imagen por defecto
         if (!isset($_FILES['imagenReceta']) || $_FILES['imagenReceta']['error'] === UPLOAD_ERR_NO_FILE) {
            return $recetaID->getRuta(); // Retorna la imagen existente   
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
