<?php

session_start(); 

unset($_SESSION);

session_destroy(); 

// Se define el título de la página
$tituloPagina = 'Salir del sistema';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal=<<<EOS
    <h1>Hasta pronto!</h1>
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