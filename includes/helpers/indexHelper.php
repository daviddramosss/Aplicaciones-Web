<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\recetaAppService;

class IndexHelper 
{
    public function __construct() 
    {
        
    }

    public function getRecetas()
    {
        $recetaAppService = recetaAppService::GetSingleton();

        $recetasFecha = $this->mostrarRecetas($recetaAppService->mostrarRecetas('fecha'), "Recetas más recientes", "swiper-fecha");
        $recetasEtiqueta = $this->mostrarRecetas($recetaAppService->mostrarRecetas('etiqueta_principal'), "Platos principales", "swiper-etiqueta");
        $recetasPrecio = $this->mostrarRecetas($recetaAppService->mostrarRecetas('precio'), "Recetas ordenadas por precio", "swiper-precio");
        $recetasIngredientes = $this->mostrarRecetas($recetaAppService->mostrarRecetas('ingrediente'), "Recetas con más ingredientes", "swiper-ingredientes");
        

        return <<<HTML
            <section>
                <video id="videoPrincipal" autoplay loop muted>
                <source src="img/video/videochef.mp4" type="video/mp4">
                Tu navegador no puede mostrar el vídeo.
                </video>
            </section>
            
            $recetasFecha
            $recetasEtiqueta
            $recetasPrecio
            $recetasIngredientes
            
             <!-- Swiper CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">    

            <!-- Swiper JS -->
            <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>  

            <!-- Se incluye el archivo JavaScript específico para manejar las interacciones en la página de inicio -->
            <script src="JS/index.js"></script>
        HTML;
    }

    public function mostrarRecetas($recetas, $titulo, $idCarrusel) {
        if (empty($recetas)) {
            return "<h2>$titulo</h2><p>No hay recetas disponibles.</p>";
        }
    
        $html = <<<HTML
        <h2>$titulo</h2>
        <div class="swiper-container-wrapper">
        <div class="swiper-container" id="$idCarrusel">
            <div class="swiper-wrapper">
        HTML;

       foreach ($recetas as $receta) {
            $html .= <<<HTML
            <div class="swiper-slide">
                <div class="receta-card">
                    <a href="mostrarReceta.php?id={$receta->getId()}">
                        <img src="img/receta/{$receta->getRuta()}" alt="{$receta->getNombre()}" class="receta-imagen">
                    </a>
                    <p class="receta-titulo">{$receta->getNombre()}</p>
                </div>
            </div>
            HTML;

           
        }

        $html .= <<<HTML
                </div> <!-- Cierra .swiper-wrapper -->
            </div> <!-- Cierra .swiper-container -->

            <div class="swiper-controls">
                <div class="swiper-button-prev" id="prev-$idCarrusel"></div>
                <div class="swiper-button-next" id="next-$idCarrusel"></div>
                <div class="swiper-pagination" id="pagination-$idCarrusel"></div>
            </div>

        </div> <!-- Cierra .swiper-container-wrapper -->
        HTML;
     

        return $html;
        }
    }
 
?>
