<?php

include __DIR__ . '/../comun/formularioBase.php';
include __DIR__ . '/../receta/recetaAppService.php';

class crearRecetaForm extends formularioBase
{
  
    public function __construct() 
    {
        parent::__construct('crearRecetaForm');
    }
    
    protected function CreateFields($datos)
    {
        $titulo = $datos['titulo'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $precio = $datos['precio'] ?? '';
        $tiempo = $datos['tiempo'] ?? '';

        $html = <<<EOF
        <fieldset>
            <legend>Nueva Receta</legend>
            
            <p><label>Título:</label> <input type="text" name="titulo" value="$titulo" required/></p>
            
            <p><label>Descripción:</label> <textarea name="descripcion" required>$descripcion</textarea></p>
            
            <p><label>Precio Final:</label> <input type="number" step="0.1" name="precio" value="$precio" required/> €</p>
            <p>Ingreso percibido estimado: <span id="ingresoEstimado">0</span> € (tras comisión MarketChef (15%))</p>

            <p><label>Tiempo de elaboración:</label> <input type="number" step="1" name="tiempo" value="$tiempo" required/> minutos</p>

            <!-- Ingredientes -->
            <p>
                <label>Ingredientes:</label> 
                <button type="button" id="addIngredient">Añadir ingrediente</button>
                <button type="button" id="closeIngredientList">Cerrar lista ingredientes</button>
            </p>

            <!-- Contenedor donde se listarán los ingredientes dinámicamente -->
            <div id="ingredientContainer">
                <!-- Aquí se insertarán los ingredientes mediante JS -->
            </div>

            <h3>Pasos para elaborar la receta</h3>
            <div id="stepsContainer">
                <p><label>Paso 1:</label> <textarea name="steps[]" required></textarea></p>
            </div>
            <button type="button" id="addStep">+ Añadir paso</button>
            <button type="button" id="removeStep">- Eliminar paso</button>
            
            <h3>Etiquetas</h3>
            <p>Añade etiquetas para recomendar tu receta: (Máximo 3)</p>
            <input type="text" id="etiquetaInput" placeholder="Escribe una etiqueta..."/>
            <button type="button" id="addTag">+ Añadir etiqueta</button>
            
            <div id="tagsContainer"></div>

            <p>
                <button type="button" onclick="location.href='index.php'">Cancelar</button>
                <button type="submit" name="guardar">Guardar</button>
            </p>
        </fieldset>

        <!-- Importar el archivo JavaScript -->
        <script src="js/crearReceta.js"></script>    
        <script src="js/ingredientes.js"></script> 
        EOF;

        return $html;
    }

    protected function Process($datos)
    {
        $result = array();

        //Comprobar bien como se hace esto
        $usuarioId = $_SESSION['usuario'] ?? null;

        //Comprobnar si funciona
        $fecha_creacion = date('Y-m-d H:i:s');

        // Saneamos los datos de entrada
        $titulo = filter_var(trim($datos['titulo'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $descripcion = filter_var(trim($datos['descripcion'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $precio = floatval($datos['precio'] ?? 0);

        $tiempo = floatval($datos['tiempo'] ?? 0);

        $ingredientes = $datos['ingredientes'] ?? [];

        $pasos = $datos['steps'] ?? [];

        $etiquetas = $datos['etiquetas'] ?? [];


        // Validaciones
        if (empty($titulo) || empty($descripcion) || $precio <= 0 || $tiempo <= 0) {
            $result[] = "Error: Todos los campos son obligatorios y el precio debe ser mayor a 0.";
        }

        if (!is_array($ingredientes) || count($ingredientes) === 0) {
            $result[] = "Error: Debes añadir al menos un ingrediente.";
        } else {
            foreach ($ingredientes as $id => $ingrediente) {
                $cantidad = floatval($ingrediente['cantidad'] ?? 0);
                $magnitud = filter_var($ingrediente['magnitud'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if ($cantidad <= 0 || empty($magnitud)) {
                    $result[] = "Error: Todos los ingredientes deben tener una cantidad válida y una magnitud seleccionada.";
                }
            }
        }

        if (!is_array($pasos) || count($pasos) === 0) {
            $result[] = "Error: La receta debe tener al menos un paso.";
        }

        if (!is_array($etiquetas)) {
            $etiquetas = [];
        }

        // Crear el array de pasos como un objeto JSON
        $pasosJSON = [];
        foreach ($pasos as $orden => $paso) {
            $paso = filter_var($paso, FILTER_SANITIZE_STRING);
            if (!empty($paso)) {
                // Guardar cada paso como parte de un objeto JSON
                $pasosJSON[] = ['orden' => $orden + 1, 'paso' => $paso];
            }
        }

        // Convertir el array de pasos a JSON
        $pasosJSON = json_encode($pasosJSON);

        if(count($result) === 0)
        {
            try
            {
                $recetaDTO = new RecetaDTO(0, $titulo, $usuarioId, $descripcion, $pasos, $tiempo, $precio, $fecha_creacion,0);

                // Crear instancia del servicio de recetas
                $recetaService = recetaAppService::GetSingleton();

                $recetaId = $recetaService->crearReceta($recetaDTO);

                $result = 'index.php';

                $app = application::getInstance();
                $mensaje = "Se ha creado la nueva actividad exitosamente";
                $app->putAtributoPeticion('mensaje', $mensaje);
          

                /*
                // Guardar ingredientes
                foreach ($ingredientes as $ingrediente) {
                    if (!isset($ingrediente['id'], $ingrediente['cantidad'], $ingrediente['magnitud'])) {
                        continue; // Saltar ingredientes mal formateados
                    }

                    $ingredienteId = intval($ingrediente['id']);
                    $cantidad = floatval($ingrediente['cantidad']);
                    $magnitud = filter_var($ingrediente['magnitud'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    if ($ingredienteId > 0 && $cantidad > 0 && !empty($magnitud)) {
                        //$recetaService->agregarIngredienteAReceta($recetaId, $ingredienteId, $cantidad, $magnitud);
                    }
                }

                

                // Guardar etiquetas
                $etiquetas = array_slice(array_unique($etiquetas), 0, 3); // Máximo 3 etiquetas únicas
                foreach ($etiquetas as $etiqueta) {
                    $etiqueta = filter_var($etiqueta, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if (!empty($etiqueta)) {
                        //$recetaService->agregarEtiquetaAReceta($recetaId, $etiqueta);
                    }
                }
                    */
            }
            catch(recetaAlreadyExistException $e)
            {
                $result[] = $e->getMessage();
            }
           
        }

        return $result;
    }
    
}