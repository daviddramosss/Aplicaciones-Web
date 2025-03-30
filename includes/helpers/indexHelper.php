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
        $helper = new estrellaMichelinHelper();

        $recetasFecha = $this->mostrarRecetas($recetaAppService->mostrarRecetasIndex('fecha'), "Recetas más recientes");
        $recetasEtiqueta = $this->mostrarRecetas($recetaAppService->mostrarRecetasIndex('etiqueta_principal'), "Recetas por tipo de comida");
        $recetasPrecio = $this->mostrarRecetas($recetaAppService->mostrarRecetasIndex('precio'), "Recetas ordenadas por precio");
        $recetasIngredientes = $this->mostrarRecetas($recetaAppService->mostrarRecetasIndex('ingrediente'), "Recetas con más ingredientes");

        return <<<HTML
            $recetasFecha
            $recetasEtiqueta
            $recetasPrecio
            $recetasIngredientes
        HTML;
    }

    public function mostrarRecetas($recetas, $titulo) {
        if (empty($recetas)) {
            return "<h2>$titulo</h2><p>No hay recetas disponibles.</p>";
        }
    
        $html = "<h2>$titulo</h2>";
        $html .= '<div class="recetas-container">';
    
        foreach ($recetas as $receta) {
            $html .= <<<HTML
                <div class="receta-card">
                    
                    <a href="">
                        <img src="img/receta/{$receta->getRuta()}" alt="{$receta->getNombre()}" class="receta-imagen">
                    </a>
                    <p class="receta-titulo">{$receta->getNombre()}</p>
                </div>
            HTML;
        }
    
        $html .= '</div>';
    
        return $html;
    }
    

}

?>
