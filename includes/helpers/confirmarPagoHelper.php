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

?>
