<?php

include __DIR__ . '/../comun/formularioBase.php';

class recetarioFormulario extends formularioBase
{
    public function __construct() 
    {
        parent::__construct('recetarioFormulario');
    }

    protected function CreateFields($datos)
    {
        // Ingredientes predefinidos (simulación hasta conectar con la BBDD)
        $ingredientesFijos = ['Tomate Frito', 'Carne Picada', 'Pimienta Molida'];
        $ingredientesHTML = '';

        foreach ($ingredientesFijos as $ingrediente) {
            $ingredientesHTML .= "<div class='ingrediente'>$ingrediente</div>";
        }
        /*   Esto es quivalente a: 
            <div class='ingrediente'>Tomate Frito</div>
            <div class='ingrediente'>Carne Picada</div>
            <div class='ingrediente'>Pimienta Molida</div>
        */

        $html = <<<EOF
        <form id="recetarioFormulario" method="POST" action="procesarDespensa.php">
            <div class="despensa-contenedor">
                <h2>Mi despensa </h2>
                <p>     
                Añade todos los ingredientes que tengas en tu cocina. Te ayudaremos a filtrar las recetas que puedes hacer
                </p>

                <div class="ingredientes-lista">$ingredientesHTML</div>
                <label for="nuevoIngrediente">Añadir ingrediente:</label>
                <input type="text" id="nuevoIngrediente" name="nuevoIngrediente" placeholder="Escribe un ingrediente...">
                <button type="button" id="agregarIngrediente">+</button>

                <button type="submit">Buscar Recetas</button>

            </div>
        </form>
        <script src="JS/recetario.js"></script>
        EOF;
        return $html;
    }
}
?>