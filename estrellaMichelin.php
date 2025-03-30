
<?php

    // Vamos a usar la función getAtributoPetición del archivo includes/application.php
    //use es\ucm\fdi\aw\getAtributoPeticion;
    require_once("includes/config.php");   

    use es\ucm\fdi\aw\helpers\estrellaMichelinHelper;

    // require_once("includes/application.php");
    // require_once("includes/entidades/usuario/userAppService.php");

    $tituloPagina = 'Estrella Michelin';

    $estrellaMichelinHelper = new estrellaMichelinHelper();

    $htmlEstrellaMichelinHelper = $estrellaMichelinHelper->iniciarRol();

    $contenidoPrincipal = <<<EOS
        $htmlEstrellaMichelinHelper
    EOS;
  
    require ("includes/comun/plantilla.php");
