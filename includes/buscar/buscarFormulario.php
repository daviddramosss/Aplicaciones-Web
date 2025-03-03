<?php

include __DIR__ . '/../comun/formularioBase.php';

class buscarFormulario extends formularioBase
{
    public function __construct() 
    {
        parent::__construct('buscarFormulario');
    }

    protected function CreateFields($datos)
    {

        $html = <<<EOF
        <form id="buscarFormulario" method="POST" action="procesarBusqueda.php">
            <div class="buscar-contenedor">
                <label for="ordenar">Ordenar por:</label>
                <select id="ordenar" name="ordenar">
                    <option value="precio">Precio</option>
                    <option value="valoracion">Valoración</option>
                </select>

                <label for="precioMin">Precio mín:</label>
                <input type="number" id="precioMin" name="precioMin" min="0">

                <label for="precioMax">Precio máx:</label>
                <input type="number" id="precioMax" name="precioMax" min="0">

                <label>Valoración:</label>
                <div class="valoracion">
                    <input type="hidden" name="valoracion" id="valoracionInput" value="0">
                    <span class="estrella" data-value="1">★</span>
                    <span class="estrella" data-value="2">★</span>
                    <span class="estrella" data-value="3">★</span>
                    <span class="estrella" data-value="4">★</span>
                    <span class="estrella" data-value="5">★</span>
                </div>

                <label for="etiquetas">Busca etiquetas:</label>
                <input type="text" id="etiquetas" name="etiquetas">
                <button type="button" id="agregarEtiqueta">+</button>
                <div id="etiquetasSeleccionadas"></div>

                <label>
                    <input type="checkbox" name="usarDespensa">
                    Usar Mi Despensa
                </label>

                <label>
                    <input type="checkbox" name="usarAlergenos">
                    Usar mis alérgenos
                </label>

                <button type="submit">Buscar</button>
            </div>
        </form>

        <script src="JS/buscar.js"></script>


        EOF;

        return $html;
    }
}
?>