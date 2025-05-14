<?php

// Se define el título de la página
$tituloPagina = 'Perfil editada con éxito';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal=<<<EOS
    <h1>¡Su perfil ha sido editada exitosamente!</h1>
    <p>Serás redirigido a la página principal en unos segundos...</p>
    <script>
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 3000); // 3000 milisegundos = 3 segundos
    </script>
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");
?>