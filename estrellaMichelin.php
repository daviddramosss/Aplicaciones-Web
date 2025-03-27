
<?php

    // Vamos a usar la función getAtributoPetición del archivo includes/application.php
    //use es\ucm\fdi\aw\getAtributoPeticion;
    require_once("includes/config.php");   
    use es\ucm\fdi\aw\application;
    use es\ucm\fdi\aw\entidades\usuario\userAppService;
    // require_once("includes/application.php");
    // require_once("includes/entidades/usuario/userAppService.php");

    $tituloPagina = 'Estrella Michelin';

    $app = application::getInstance();

    $userAppService = userAppService::GetSingleton();

    $user = $userAppService->buscarUsuario($app->getEmail());

    

    // Se obtiene el rol del usuario
    $rol = $user->getRol();

    // Si el rol no es chef, se redirige a la página principal y se deja de ejecutar el código de este archivo
    if($rol != 'Chef'){

        // Mostramos un texto
        $contenidoPrincipal = <<<EOS
            <link rel="stylesheet" href="CSS/index.css">
            <h1>¡Conviertete en un Chef Estrella Michelin!</h1>
            <p> Si quieres ser un chef, debes ponerte en contacto con nosotros y comentarnos porqué quieres ser chef, tu experiencia y tus habilidades</p>
            <p> No te olvides de adjuntar tu DNI y tu cuenta bancaria para que podamos comprobar tu identidad y gestionar los pagos</p>

            <p> ¡Para contactar con nosotros puedes acceder a la sección de contacto o simplemente haz click <a href="contacto.php">aquí</a>!</p>   
        EOS;
    }
    else{

        $contenidoPrincipal = <<<EOS
            <link rel="stylesheet" href="CSS/index.css">
            <h1> ¡Bienvenido a tu cocina Chef!</h1>
            <p>Aqui debe ir el saldo</p>

            <div class="crear-receta-container">
                <a href="crearReceta.php" class="boton-crear" id="botonCrearReceta">Crear Receta</a>
            </div>

        EOS;
    }

    // En caso contrario, se define el contenido principal de la página, que sera insertado en la plantilla
    // Se define el título de la página
   





    require ("includes/comun/plantilla.php");
