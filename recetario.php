<?php

    require_once("includes/config.php");   

    use es\ucm\fdi\aw\helpers\miRecetarioHelper;

    $tituloPagina = 'Mi Recetario';

    $miRecetarioHelper = new miRecetarioHelper();
    $miRecetarioHelper->init(); 
    $htmlMiRecetarioHelper = $miRecetarioHelper->iniciarRol();

    $contenidoPrincipal = <<<EOS
        $htmlMiRecetarioHelper
    EOS;
  
    require ("includes/comun/plantilla.php");

?>
