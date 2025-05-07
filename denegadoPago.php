<?php

// Se define el título de la página
$tituloPagina = 'Pago denegado';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <div class="aviso error">
        <h1>&#9888; ¡Pago denegado!</h1>
        <p>Lo sentimos, ha ocurrido un error y no se ha podido completar tu compra.</p>
        <p>Serás redirigido a la página principal en unos segundos...</p>
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