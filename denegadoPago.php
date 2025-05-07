<?php

// Se define el título de la página
$tituloPagina = 'Pago denegado';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal=<<<EOS
    <div style="background-color: #ffdddd; border-left: 6px solid #f44336; padding: 20px; margin: 40px auto; max-width: 600px; font-family: sans-serif;">
        <h1 style="color: #a94442; font-size: 2em; text-align: center;">&#9888; ¡Pago denegado!</h1>
        <p style="font-size: 1.1em; color: #333; text-align: center;">
            Lo sentimos, ha ocurrido un error y no se ha podido completar tu compra.
        </p>
        <p style="text-align: center;">Serás redirigido a la página principal en unos segundos...</p>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 3000);
    </script>
EOS;


// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");
?>