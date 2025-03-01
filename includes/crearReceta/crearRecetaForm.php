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
            
            <p><label>Precio Final:</label> <input type="number" step="0.01" name="precio" value="$precio" required/> €</p>
            <p>Ingreso percibido estimado: <span id="ingresoEstimado">0</span> € (tras comisión MarketChef)</p>
            
            <p><label>Ingredientes:</label> <button type="button" id="addIngredient">+ Añadir ingrediente</button></p>
            <div id="ingredientList"></div>
            
            <h3>Pasos para elaborar la receta</h3>
            <div id="stepsContainer">
                <p><label>Paso 1:</label> <textarea name="steps[]" required></textarea></p>
            </div>
            <button type="button" id="addStep">+ Añadir paso</button>
            <button type="button" id="removeStep">- Eliminar paso</button>
            
            <h3>Selecciona los alérgenos</h3>
            <p>
                <input type="checkbox" name="alergenos[]" value="mariscos"> Mariscos
                <input type="checkbox" name="alergenos[]" value="frutos_secos"> Frutos secos
                <input type="checkbox" name="alergenos[]" value="gluten"> Gluten
            </p>
            <p><input type="checkbox" name="confirmAlergenos" required> Afirmo que he seleccionado correctamente los alérgenos</p>
            
            <h3>Etiquetas</h3>
            <p>Añade etiquetas para recomendar tu receta:</p>
            <div id="tagsContainer"></div>
            <button type="button" id="addTag">+ Añadir etiqueta</button>
            
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