
<?php

require_once("includes/config.php");

// Página de Gestionar usuarios, exclusiva para el rol Admin
$tituloPagina = 'Gestionar Usuarios';

// Guardamos el contenido principal de la página en la variable dinámica que gestiona la plantilla para cargar el contenido
$contenidoPrincipal = <<<EOS

     <!-- Breve introducción provisional de cómo funcionará la página cuando se implemente -->
    <h2>Panel de administración de usuarios</h2>
    <p>En este panel puedes gestionar los usuarios de la aplicación.</p>
    <p>Vas a poder borrar, crear, o editar los usuarios que quieras</p>
    <p>Filtrando por ID, Email, Nombre, etc...</p>

            

EOS;


require("includes/comun/plantilla.php");

?>