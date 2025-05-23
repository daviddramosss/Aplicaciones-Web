<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\comun\formularioBase;

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
        // Recuperar valores previos o establecerlos vacíos
        $buscarPlato = $datos['buscarPlato'] ?? '';
        $ordenar = $datos['ordenar'] ?? '';
        $precioMin = $datos['precioMin'] ?? 0;
        $precioMax = $datos['precioMax'] ?? 100;
        // Generación del HTML para el formulario
        $html = <<<EOF
            <!-- Sidebar con los filtros -->
            <aside class="sidebar_buscar">
                    <h2>Filtros de búsqueda</h2>
                    <hr>
                    <!-- Campo de búsqueda -->
                    <label for="buscarPlato">Nombre del plato:</label>
                    <input type="text" id="buscarPlato" name="buscarPlato" placeholder="Ej: Pizza margarita" value="$buscarPlato">

                    <!-- Selector para ordenar -->
                    <label for="ordenar">Ordenar por:</label>
                    <select id="ordenar" name="ordenar" value="$ordenar">
                        <option value="precio_asc">Precio (más barato primero)</option>
                        <option value="precio_desc">Precio (más caro primero)</option>
                        <option value="nombre_asc">Nombre (A-Z)</option>
                        <option value="nombre_desc">Nombre (Z-A)</option>
                        <!-- <option value="popularidad">Más populares</option> -->
                    </select>

                    <!-- Rango de precios con sliders -->
                    <label for="precioMin">Precio mín: <span id="minValue">0</span>€</label>
                    <input type="range" id="precioMin" name="precioMin" min="0" max="100" value="$precioMin">

                    <label for="precioMax">Precio máx: <span id="maxValue">100</span>€</label>
                    <input type="range" id="precioMax" name="precioMax" min="0" max="100" value="$precioMax">

                    <label>Etiquetas</label>
                    <div id="tagsContainer" class="tags_container_buscar"></div>

                    <input type="hidden" name="etiquetas" id="etiquetasSeleccionadas" value="">

                    <!-- Botón de búsqueda -->
                    <button class="send-button" type="submit">BUSCAR</button>
            </aside>

            <!-- Zona de resultados -->
            <div id="resultados_buscar_div"></div>

        <!-- Enlace al script que maneja interacciones dinámicas -->
        <script src="JS/buscar.js"></script>
        <script src="JS/etiquetas.js"></script>

    EOF;

        // Devuelve el formulario generado
        return $html;
    }

    protected function Heading()
    {
       $html = 
       '<!-- Enlace a la hoja de estilos específica para la página de búsqueda -->
        <link rel="stylesheet" href="CSS/estiloGeneral.css">';
        return $html;
    }
}
?>
