<?php

include __DIR__ . '/../comun/formularioBase.php';

// Clase buscarFormulario que extiende de formularioBase
class buscarFormulario extends formularioBase
{
    // Constructor de la clase
    public function __construct() 
    {
        parent::__construct('buscarFormulario');
    }

    // Método protegido que crea los campos del formulario 
    protected function CreateFields($datos)
    {
        // Generación del HTML para el formulario
        $html = <<<EOF
        <form id="buscarFormulario" method="POST" action="procesarBusqueda.php">
            <div class="buscar-contenedor">

                <!-- Campo de búsqueda -->
                <label for="buscarPlato">Buscar:</label>
                <input type="text" id="buscarPlato" name="buscarPlato" placeholder="Escribe el nombre del plato...">

                <!-- Selector para ordenar resultados -->
                <label for="ordenar">Ordenar por:</label>
                <select id="ordenar" name="ordenar">
                    <option value="precio">Precio</option>
                    <option value="valoracion">Valoración</option>
                </select>

                <!-- Campos de filtro por precio mínimo y máximo -->
                <label for="precioMin">Precio mín:</label>
                <input type="number" id="precioMin" name="precioMin" min="0">

                <label for="precioMax">Precio máx:</label>
                <input type="number" id="precioMax" name="precioMax" min="0">

                <!-- Filtro por valoración mediante estrellas -->
                <label>Valoración:</label>
                <div class="valoracion">
                    <input type="hidden" name="valoracion" id="valoracionInput" value="0">
                    <span class="estrella" data-value="1">★</span>
                    <span class="estrella" data-value="2">★</span>
                    <span class="estrella" data-value="3">★</span>
                    <span class="estrella" data-value="4">★</span>
                    <span class="estrella" data-value="5">★</span>
                </div>

                <!-- Campo para buscar recetas por etiquetas -->
                <label for="etiquetas">Busca etiquetas:</label>
                <div class="etiquetas-container">
                    <input type="text" id="etiquetas" name="etiquetas">
                    <button type="button" id="agregarEtiqueta">+</button>
                </div>
                <div id="etiquetasSeleccionadas"></div>

                <!-- Opción para usar ingredientes de la despensa del usuario -->
                <div class="checkbox-container">
                    <input type="checkbox" id="usarDespensa" name="usarDespensa">
                    <label for="usarDespensa">Usar Mi Despensa</label>
                </div>

                <!-- Opción para filtrar por alérgenos del usuario -->
                <div class="checkbox-container">
                    <input type="checkbox" id="usarAlergenos" name="usarAlergenos">
                    <label for="usarAlergenos">Usar mis alérgenos</label>
                </div>

                <!-- Botón para ejecutar la búsqueda -->
                <button type="submit">Buscar</button>
            </div>
        </form>

        <!-- Enlace al script que maneja interacciones dinámicas -->
        <script src="JS/buscar.js"></script>

    EOF;

        // Devuelve el formulario generado
        return $html;
    }

    protected function Heading()
    {
       $html = '<!-- Enlace a la hoja de estilos específica para la página de búsqueda -->
    <link rel="stylesheet" href="CSS/buscar.css">
    
    <!-- Enlace al script JavaScript que maneja la interacción en la búsqueda -->
    <script src="JS/buscar.js" defer></script>
    
    <!-- Título de la página -->
    <h1>Buscar Recetas</h1>';
    return $html;
    }
}
?>
