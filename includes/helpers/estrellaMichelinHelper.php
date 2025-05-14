<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\application;
use es\ucm\fdi\aw\entidades\usuario\{userDTO, userAppService};
use es\ucm\fdi\aw\entidades\receta\{recetaAppService};
use es\ucm\fdi\aw\entidades\chef\{chefAppService};

class estrellaMichelinHelper {

    private $user;

    public function __construct() {
       
    }

    public function init(){
        $app = application::getInstance();

        $userAppService = userAppService::GetSingleton();

        $this->user = $userAppService->buscarUsuario(new userDTO(null, null, null, $app->getEmail(), null, null, null)); // Buscamos al usuario mediante su email ($app->getEmail());

    }

    
    public function iniciarRol() {    

        // Se obtiene el rol del usuario
        $rol = $this->user->getRol();

        // Si el rol no es chef, se redirige a la página principal y se deja de ejecutar el código de este archivo
        if($rol == 'User'){

            // Mostramos un texto
            return <<<HTML
                <h1>¡Conviertete en un Chef Estrella Michelin!</h1>
                <p> Si quieres ser un chef, debes ponerte en contacto con nosotros y comentarnos porqué quieres ser chef, tu experiencia y tus habilidades</p>
                <p> No te olvides de adjuntar tu DNI y tu cuenta bancaria para que podamos comprobar tu identidad y gestionar los pagos</p>

                <p> ¡Para contactar con nosotros puedes acceder a la sección de contacto o simplemente haz click <a href="contacto.php">aquí</a>!</p>   
            HTML;
        }else if ($rol == 'Admin'){
            
            $recetasHTML = $this->mostrarRecetaAdmin();

            return <<<HTML
                <h1> ¡Bienvenido a la cocina Admin!</h1>

                <p> Aquí podrás ver y editar las recetas que los chefs han creado.</p>
                 <p> Al hacer clic en cada uno de tus platos podrás editarlos o borrarlos de una manera sencilla.</p>               
                {$recetasHTML}
            HTML;        
        
        }else if ($rol == 'Chef'){

            $recetasHTML = $this->mostrarRecetasChef();

            $chefAppService = chefAppService::GetSingleton();
            $chefDTO = $chefAppService->informacionChef($this->user);

            return <<<HTML
                <h1> ¡Bienvenido a tu cocina Chef!</h1>

                <p> Es un placer tenerte de vuelta, <b>{$this->user->getNombre()}</b>. Desde MarketChef estamos deseando de ver tus nuevas creaciones, para ello puedes usar la funcionalidad de crear recetas.</p>
                <div>
                    <button type="button" class="send-button" onclick="location.href='crearReceta.php'">CREAR NUEVA RECETA</button>
                </div>

                <p> Además al hacer clic en cada uno de tus platos podrás editarlos o borrarlos de una manera sencilla.</p>               
                {$recetasHTML}

                <h2>Saldo acumulado hasta el momento: {$chefDTO->getSaldo()} €</h2>

            HTML;
        }
    }

    public function mostrarRecetasChef() {
        $recetaAppService = recetaAppService::GetSingleton();
        $recetas = $recetaAppService->mostrarRecetasPorAutor($this->user);

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