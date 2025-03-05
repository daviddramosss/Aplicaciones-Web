
<?php

require_once("includes/config.php");

$tituloPagina = 'Gestionar Usuarios';

$contenidoPrincipal = <<<EOS

    <h2>Panel de administración de usuarios</h2>
    <p>En este panel puedes gestionar los usuarios de la aplicación.</p>
    <p>Vas a poder borrar, crear, o editar los usuarios que quieras</p>
    <p>Filtrando por ID, Email, Nombre, etc...</p>

            

EOS;


require("includes/comun/plantilla.php");

?>