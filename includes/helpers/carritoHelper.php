<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};

class carritoHelper
{
    private $recetas;
    private $total;

    public function __construct()
    {
        $this->recetas = [];
        $this->total = 0.0;
        $this->cargarRecetas();
    }

    private function cargarRecetas()
    {
        if (!isset($_SESSION)) session_start();
        $carrito = $_SESSION['carrito'] ?? [];
        $recetaService = recetaAppService::GetSingleton();

        foreach ($carrito as $id) {
            $receta = $recetaService->buscarRecetaPorId(new recetaDTO($id, null, null, null, null, null, null, null, null));
            if ($receta) {
                $this->recetas[] = $receta;
                $this->total += floatval($receta->getPrecio());
            }
        }
    }

    public function generarHTML(): string
    {
        if (empty($this->recetas)) {
            return "<p>No hay recetas en el carrito.</p>";
        }

        $html = "<h1>Carrito de Recetas</h1>";
        $html .= "<ul class='lista-carrito'>";

        foreach ($this->recetas as $r) {
            $nombre = htmlspecialchars($r->getNombre());
            $precio = number_format($r->getPrecio(), 2);
            $html .= "<li>$nombre - $precio €</li>";
        }

        $totalFormatted = number_format($this->total, 2);
        $html .= "</ul>";
        $html .= "<p><strong>Total:</strong> $totalFormatted €</p>";

        $html .= <<<HTML
            <form action="iniciarPago.php" method="post">
                <input type="hidden" name="importeTotal" value="{$this->getImporteCentesimos()}">
                <button type="submit" class="boton-pagar">Pagar con tarjeta</button>
            </form>
        HTML;

        return $html;
    }

    private function getImporteCentesimos(): int
    {
        return intval(round($this->total * 100));
    }
}

?>