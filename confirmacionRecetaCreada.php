<?php

$tituloPagina = 'Receta creada con éxito';

$contenidoPrincipal=<<<EOS
    <h1>¿Su receta ha sido creada exitosamente!</h1>
    <p>Serás redirigido a la página principal en unos segundos...</p>
    <script>
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 3000); // 3000 milisegundos = 3 segundos
    </script>
EOS;

require("includes/comun/plantilla.php");
?>