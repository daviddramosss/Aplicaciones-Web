
<?php

    require_once("includes/config.php");   

    use es\ucm\fdi\aw\helpers\estrellaMichelinHelper;

    $tituloPagina = 'Estrella Michelin';

    $estrellaMichelinHelper = new estrellaMichelinHelper();
    $htmlEstrellaMichelinHelper = $estrellaMichelinHelper->iniciarRol();

    $contenidoPrincipal = <<<EOS
        $htmlEstrellaMichelinHelper
    EOS;
  
    require ("includes/comun/plantilla.php");

?>
