<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};

class carritoHelper
{
    private $recetas;
    private $total;

    public function __construct()
    {       
    }

    public function init()
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

    public function generarHTML()
    {
        if (empty($this->recetas)) {
            return "<p>No hay recetas en el carrito.</p>";
        }
    
        $html = "<h1>Carrito de Recetas</h1>";
        $html .= "<div class='carrito-container'>";
    
        foreach ($this->recetas as $receta) {
            $nombre = htmlspecialchars($receta->getNombre());
            $precio = number_format($receta->getPrecio(), 2);
            $rutaImg = htmlspecialchars($receta->getRuta());
            $idReceta = $receta->getId();
    
            $html .= <<<HTML
            <div class="carrito-item" data-id="$idReceta" data-precio="{$receta->getPrecio()}">
                <img src="img/receta/$rutaImg" alt="$nombre" class="carrito-imagen">
                <div class="carrito-info">
                    <p class="carrito-nombre">$nombre</p>
                    <p class="carrito-precio">$precio €</p>
                </div>
                <button class="carrito-eliminar-boton" data-id="$idReceta">Eliminar</button>
            </div>
            HTML;
        
            $html .= '<script src="js/carrito.js"></script>';

        }
    
        $totalFormatted = number_format($this->total, 2);
        $html .= "<h2>Total: $totalFormatted €</h2>";
    
        $html .= <<<HTML
            <form action="iniciarPago.php" method="post">
                <input type="hidden" name="importeTotal" value="{$this->getImporteCentesimos()}">
                <button type="submit" class="send-button">PAGAR CON TARJETA</button>
            </form>
        HTML;
    
        $html .= "</div>";
    
        return $html;
    }
    private function getImporteCentesimos()
    {
        return intval(round($this->total * 100));
    }
}

?>