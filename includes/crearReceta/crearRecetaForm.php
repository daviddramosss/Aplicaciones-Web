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

        $html = <<<EOF
        <fieldset>
            <legend>Nueva Receta</legend>
            
            <p><label>Título:</label> <input type="text" name="titulo" value="$titulo" required/></p>
            
            <p><label>Descripción:</label> <textarea name="descripcion" required>$descripcion</textarea></p>
            
            <p><label>Precio Final:</label> <input type="number" step="0.1" name="precio" value="$precio" required/> €</p>
            <p>Ingreso percibido estimado: <span id="ingresoEstimado">0</span> € (tras comisión MarketChef (15%))</p>

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


}