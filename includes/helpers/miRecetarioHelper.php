<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\application;
use es\ucm\fdi\aw\entidades\usuario\{userDTO, userAppService};
use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};
use es\ucm\fdi\aw\entidades\chef\{chefAppService, chefDTO};

class miRecetarioHelper {

    private $user;

    public function __construct() {
        $app = application::getInstance();

        $userAppService = userAppService::GetSingleton();

        $this->user = $userAppService->buscarUsuario(new userDTO(null, null, null, $app->getEmail(), null, null, null)); // Buscamos al usuario mediante su email ($app->getEmail());

    }

    public function mostrarRecetasCompradas() {
        $recetaAppService = recetaAppService::GetSingleton();
        $recetas = $recetaAppService->mostarRecetasPorComprador($this->user);

        if (empty($recetas)) {
            return "<p>No tienes recetas compradas aún.</p>";
        }

        $html = '<div class="recetas-container">';
    
        foreach ($recetas as $receta) {
            $html .= <<<HTML
                <div class="receta-card">
                    <a href="editarReceta.php?id={$receta->getId()}">
                        <img src="img/receta/{$receta->getRuta()}" alt="{$receta->getNombre()}" class="receta-imagen">
                    </a>
                    <p class="receta-titulo">{$receta->getNombre()}</p>
                </div>
            HTML;
        }
    
        $html .= '</div>';

        return $html;
    }

    public function mostrarRecetaAdmin(){
        $recetaAppService = recetaAppService::GetSingleton();
        $recetas = $recetaAppService->mostrarRecetas('todas');
        //$recetas = $recetaAppService->mostrarTodasLasRecetas();

        if (empty($recetas)) {
            return "<p>No tienes recetas publicadas aún.</p>";
        }

        $html = '<div class="recetas-container">';
    
        foreach ($recetas as $receta) {
            $html .= <<<HTML
                <div class="receta-card">
                    <a href="editarReceta.php?id={$receta->getId()}">
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