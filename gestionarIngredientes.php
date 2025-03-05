
<?php

require_once("includes/config.php");

$tituloPagina = 'Gestionar Ingredientes';

$contenidoPrincipal = <<<EOS

    <h2>Panel de administración de ingredientes</h2>
    <p>En este panel puedes gestionar los ingredintes de la aplicación.</p>
    <p>Vas a poder borrar, crear, o editar los ingredientes que quieras</p>
    <p>Filtrando por ID, Receta, Nombre, etc...</p>

            

EOS;


require("includes/comun/plantilla.php");

?>