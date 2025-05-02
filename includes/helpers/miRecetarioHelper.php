<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\application;
use es\ucm\fdi\aw\entidades\usuario\{userDTO, userAppService};
use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};
use es\ucm\fdi\aw\entidades\recetaComprada\{recetaCompradaAppService, recetaCompradaDTO};
use es\ucm\fdi\aw\entidades\chef\{chefAppService, chefDTO};

class miRecetarioHelper {

    private $user;

    public function __construct() {
       //quito lo que habia aqui y lo pongo en el init
    }

    public function init() {
        $app = application::getInstance();

        $userAppService = userAppService::GetSingleton();

        $this->user = $userAppService->buscarUsuario(new userDTO(null, null, null, $app->getEmail(), null, null, null)); // Buscamos al usuario mediante su email ($app->getEmail());
        
    }

    public function iniciarRol() {    

        if($this->user == false){ //si no estamos logeados, nos vamos al login
            header("Location: login.php");
            exit();
        }

        // Se obtiene el rol del usuario
        $rol = $this->user->getRol();

        // Si el rol no es chef, se redirige a la página principal y se deja de ejecutar el código de este archivo
        if($rol == 'User' || $rol == 'Chef' || $rol == 'Admin'){

            $recetasHTML = $this->mostrarRecetasCompradas();

            return <<<HTML
                <h1> ¡Bienvenido a tu Recetario!</h1>

                <p> Es un placer tenerte de vuelta, <b>{$this->user->getNombre()}</b>. Desde aqui puedes consultar tus recetas compradas. Anímate a ampliar tu despensa!</p>
                <div>
                    <button type="button" class="send-button" onclick="location.href='buscar.php'">BUSCA NUEVAS RECETAS</button>
                </div>

                <p> Al hacer clic en cada uno de tus platos podrás ver más información.</p>               
                {$recetasHTML}

            HTML;
        }
    }

    public function mostrarRecetasCompradas() {
        $recetaCompradaAppService = recetaCompradaAppService::GetSingleton();
        $recetas = $recetaCompradaAppService->mostrarRecetasPorComprador(new recetaCompradaDTO($this->user->getId(), null));

        if (empty($recetas)) {
            return "<p>No tienes recetas compradas aún.</p>";
        }

        $html = '<div class="recetas-container">';
    
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
        
}



?>