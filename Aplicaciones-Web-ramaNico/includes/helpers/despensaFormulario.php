<?php

// Se incluye el archivo de la clase base 'formularioBase'
namespace es\ucm\fdi\aw\helpers;
use es\ucm\fdi\aw\comun\formularioBase;
// include __DIR__ . '/../comun/formularioBase.php';

// Definición de la clase 'despensaFormulario' que extiende de 'formularioBase', heredando su funcionalidad
class despensaFormulario extends formularioBase
{
    // Constructor de la clase
    public function __construct() 
    {
        parent::__construct('despensaFormulario');
    }

    // Método protegido que crea los campos del formulario 
    protected function CreateFields($datos)
    {
        // Ingredientes predefinidos para simular ingredientes hasta que se conecte a la base de datos
        $ingredientesFijos = ['Tomate Frito', 'Carne Picada', 'Pimienta Molida'];

        // Variable para almacenar el HTML generado de la lista de ingredientes
        $ingredientesHTML = '';

        // Generación dinámica de los ingredientes a partir de la lista de ingredientes predefinidos
        foreach ($ingredientesFijos as $ingrediente) {
            $ingredientesHTML .= "<div class='ingrediente'>$ingrediente</div>";
        }

        // Generación del HTML para el formulario
        $html = <<<EOF
            <!-- Formulario para gestionar los ingredientes de la despensa -->
            <form id="despensaFormulario" method="POST" action="procesarDespensa.php">
                <div class="despensa-contenedor">
                    <!-- Título del formulario -->
                    <h2>Mi despensa </h2>
                    <!-- Descripción del formulario -->
                    <p>     
                        Añade todos los ingredientes que tengas en tu cocina. Te ayudaremos a filtrar las recetas que puedes hacer.
                    </p>

                    <!-- Lista de ingredientes generados dinámicamente -->
                    <div class="ingredientes-lista">$ingredientesHTML</div>

                    <!-- Campo para agregar un nuevo ingrediente -->
                    <label for="nuevoIngrediente">Añadir ingrediente:</label>
                    <input type="text" id="nuevoIngrediente" name="nuevoIngrediente" placeholder="Escribe un ingrediente...">
                    
                    <!-- Botón para añadir un nuevo ingrediente (sin funcionalidad aún) -->
                    <button type="button" id="agregarIngrediente">+</button>

                    <!-- Botón para enviar el formulario y buscar recetas basadas en los ingredientes añadidos -->
                    <button type="submit">Buscar Recetas</button>

                </div>
            </form>

            <!-- Enlace al archivo JS específico para manejar interacciones y validaciones en el formulario -->
            <script src="JS/despensa.js"></script>
            
        EOF;

        // Devuelve el HTML generado del formulario
        return $html;
    }

    protected function defineStyle()
    {
        $html = '<!-- Enlace al archivo CSS específico para el formulario de la despensa -->
    <link rel="stylesheet" href="CSS/despensa.css">';
    return $html;
    }
}
?>
