<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\helpers\buscarFormulario;
use es\ucm\fdi\aw\entidades\receta\recetaAppService;

    class buscarHelper {

        private $htmlFormBuscar;
        private $recetas;
        // constructor
        public function __construct() {

            $buscarFormulario = new buscarFormulario();
            // $recetaAppService = new recetaAppService();

            // Genera el HTML del formulario llamando al método Manage(), que devuelve un formulario listo para ser mostrado
            $this->htmlFormBuscar = $buscarFormulario->Manage();
            // $this->recetas = $recetaAppService->mostrarTodasLasRecetas();

        }

       /*  public static function buscarRecetas($busqueda) {
            $recetaAppService = new recetaAppService();
            $recetas = $recetaAppService->buscarRecetas($busqueda);
            return $recetas;
        } 
        */

        public function print(){

            $html = $this->htmlFormBuscar;

            $html.= 'hola';
            return $html;
        }
    }
/* 
    // Si se recibe una petición AJAX, procesamos la búsqueda
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        $helper = new HelperBusqueda();
        $helper->buscarRecetas($titulo, $descripcion);
    }
 */
?>


