
<?php

require_once("includes/config.php");

// Se define el título de la página
$tituloPagina = 'Gestionar Usuarios';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
     <!-- Breve introducción provisional de cómo funcionará la página cuando se implemente -->
    <h2>Panel de administración de usuarios</h2>
    <p>En este panel puedes gestionar los usuarios de la aplicación.</p>
    <p>Vas a poder borrar, crear, o editar los usuarios que quieras</p>
    <p>Filtrando por ID, Email, Nombre, etc...</p>           

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>