<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\application;
use es\ucm\fdi\aw\entidades\usuario\userAppService;
use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};




class estrellaMichelinHelper {

    private $user;

    public function __construct() {
        $app = application::getInstance();

        $userAppService = userAppService::GetSingleton();

        $this->user = $userAppService->buscarUsuario($app->getEmail());

    }

    
    public function iniciarRol() {    

        // Se obtiene el rol del usuario
        $rol = $this->user->getRol();

        // Si el rol no es chef, se redirige a la página principal y se deja de ejecutar el código de este archivo
        if($rol != 'Chef'){

            // Mostramos un texto
            return <<<HTML
                <link rel="stylesheet" href="CSS/index.css">
                <h1>¡Conviertete en un Chef Estrella Michelin!</h1>
                <p> Si quieres ser un chef, debes ponerte en contacto con nosotros y comentarnos porqué quieres ser chef, tu experiencia y tus habilidades</p>
                <p> No te olvides de adjuntar tu DNI y tu cuenta bancaria para que podamos comprobar tu identidad y gestionar los pagos</p>

                <p> ¡Para contactar con nosotros puedes acceder a la sección de contacto o simplemente haz click <a href="contacto.php">aquí</a>!</p>   
            HTML;
        }
        else{

            $recetasHTML = $this->mostrarRecetasChef();

            return <<<HTML
                <link rel="stylesheet" href="CSS/index.css">
                <h1> ¡Bienvenido a tu cocina Chef!</h1>
                <p>Aqui debe ir el saldo:</p>

                {$recetasHTML}

                <div class="crear-receta-container">
                    <a href="crearReceta.php" class="boton-crear" id="botonCrearReceta">Crear Receta</a>
                </div>

            HTML;
        }
    }

    public function mostrarRecetasChef() {
        $recetaAppService = recetaAppService::GetSingleton();
        $recetas = $recetaAppService->mostarRecetasPorAutor($this->user);

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