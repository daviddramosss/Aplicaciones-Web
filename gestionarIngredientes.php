
<?php

require_once("includes/config.php");

// Página de gestionar ingredientes, exclusiva para el rol Admin
$tituloPagina = 'Gestionar Ingredientes';

// Guardamos el contenido principal de la página en la variable dinámica que gestiona la plantilla para cargar el contenido
$contenidoPrincipal = <<<EOS

    <!-- Breve introducción provisional de cómo funcionará la página cuando se implemente -->
    <h2>Panel de administración de ingredientes</h2>
    <p>En este panel puedes gestionar los ingredintes de la aplicación.</p>
    <p>Vas a poder borrar, crear, o editar los ingredientes que quieras</p>
    <p>Filtrando por ID, Receta, Nombre, etc...</p>

            

EOS;


require("includes/comun/plantilla.php");

?>