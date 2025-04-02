<?php

namespace es\ucm\fdi\aw\helpers;

require_once __DIR__ . '/../config.php'; // Necesario para que no salte un Fatal Error diciendo que no encuentra la clase es\ucm\fdi\aw\...
use es\ucm\fdi\aw\helpers\buscarFormulario;
use es\ucm\fdi\aw\entidades\receta\recetaAppService;

    class buscarHelper {

        private $htmlFormBuscar;

        // Atributos del formulario para la búsqueda dinámica
        private $buscarPlato = "";
        private $ordenar = "";
        private $precioMin = 0;
        private $precioMax = 100;
        private $valoracion = 0;
        private $etiquetas = "";
        // constructor
        public function __construct() {

            $buscarFormulario = new buscarFormulario();
            $recetaAppService = recetaAppService::GetSingleton();

            // Genera el HTML del formulario llamando al método Manage(), que devuelve un formulario listo para ser mostrado
            $this->htmlFormBuscar = $buscarFormulario->Manage();

        }

       /*  public static function buscarRecetas($busqueda) {
            $recetaAppService = new recetaAppService();
            $recetas = $recetaAppService->buscarRecetas($busqueda);
            return $recetas;
        } 
        */

        public function print(){

            $html = $this->htmlFormBuscar;

/* 
            $html.= $this->busquedaDinamica(
                $this->buscarPlato, 
                $this->ordenar, 
                $this->precioMin, 
                $this->precioMax, 
                $this->valoracion, 
                $this->etiquetas
            ); 
*/

            return $html;
        }

        public function busquedaDinamica($buscarPlato, $ordenar, $precioMin, $precioMax, $valoracion, $etiquetas){
            $recetaAppService = recetaAppService::GetSingleton();
            $recetas = $recetaAppService->busquedaDinamica($buscarPlato, $ordenar, $precioMin, $precioMax, $valoracion, $etiquetas);
            if (empty($recetas)) {
                return "<p>No existen recetas que cumplan esos criterios.</p>";
            }
    
            $html = '<div class="recetas_container_buscar">';
        
            foreach ($recetas as $receta) {
                $html .= <<<HTML
                    <div class="receta-card">
                        <a href="mostrarReceta.php?id={$receta->getId()}">
                            <img src="img/receta/{$receta->getRuta()}" alt="{$receta->getNombre()}" class="receta-imagen">
                        </a>
                        <p class="receta-titulo">{$receta->getNombre()}</p>
                    </div>
                HTML;
            }
        
            $html .= '</div>';
    
            return $html;
        }

        public function procesarBusqueda($postData) {
            
            $this->buscarPlato = $postData['buscarPlato'] ?? '';
            $this->ordenar = $postData['ordenar'] ?? '';
            $this->precioMin = $postData['precioMin'] ?? 0;
            $this->precioMax = $postData['precioMax'] ?? 100;
            $this->valoracion = $postData['valoracion'] ?? 0;
            $this->etiquetas = $postData['etiquetas'] ?? '';
            
            return $this->busquedaDinamica($this->buscarPlato, $this->ordenar, $this->precioMin, $this->precioMax, $this->valoracion, $this->etiquetas);
        }


    }

    // Si se recibe una petición AJAX, procesamos la búsqueda
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $buscarHelper = new buscarHelper();
        $resultado = $buscarHelper->procesarBusqueda($_POST); // Recibimos los datos del formulario();
        echo json_encode($resultado);
        exit;
    }

?>


