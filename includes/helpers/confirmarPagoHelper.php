<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\recetaComprada\{recetaCompradaDTO, recetaCompradaAppService};

class confirmarPagoHelper
{
    public function procesar()
    {        
        $recetaCompradaService = recetaCompradaAppService::GetSingleton();

        foreach ($_SESSION['carrito'] as $idReceta) {       
            $recetaCompradaDTO = new recetaCompradaDTO($_SESSION['id'], $idReceta);

            if(!$recetaCompradaService->esComprador($recetaCompradaDTO)){
                $comprada = $recetaCompradaService->comprarReceta($recetaCompradaDTO);
            }

        }
        
        if(!$comprada) return "Error al comprar la receta";

        unset($_SESSION['carrito']);

        // Devuelve el contenido HTML
        return <<<HTML
        <div style="background-color: #ddffdd; border-left: 6px solid #4CAF50; padding: 20px; margin: 40px auto; max-width: 600px; font-family: sans-serif;">
            <h1 style="color: #2e7d32; font-size: 2em; text-align: center;">&#10004; ¡Pago realizado con éxito!</h1>
            <p style="font-size: 1.1em; color: #333; text-align: center;">
                ¡Gracias por tu compra! Todo ha salido correctamente.
            </p>
            <p style="text-align: center;">Serás redirigido a la página principal en unos segundos...</p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 3000);
        </script>
        HTML;

    }
}

?>
