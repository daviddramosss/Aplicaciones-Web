<?php

namespace es\ucm\fdi\aw\helpers;

class confirmarPagoHelper
{
    public function procesar(): string
    {
        // Vacía el carrito
        unset($_SESSION['carrito']);

        // Devuelve el contenido HTML
        return <<<HTML
            <h1>¡Su pago ha sido realizado con éxito!</h1>
            <p>Serás redirigido a la página principal en unos segundos...</p>
            <script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 3000);
            </script>
        HTML;
    }
}
