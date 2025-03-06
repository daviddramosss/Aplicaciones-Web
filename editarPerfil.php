
<?php

require_once("includes/config.php");

// Página de editar perfil
$tituloPagina = 'Editar perfil';

// Guardamos el contenido principal de la página en la variable dinámica que gestiona la plantilla para cargar el contenido
$contenidoPrincipal = <<<EOS

     <!-- Breve introducción provisional de cómo funcionará la página cuando se implemente -->
    <h2>Editar perfil del usuario</h2>
    <p>En este panel puedes editar tu perfil.</p>
    <p>Vas a poder editar tus datos, como tu nombre, apellido, etc.</p>
EOS;

require("includes/comun/plantilla.php");

?>