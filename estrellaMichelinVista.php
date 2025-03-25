<?php

class EstrellaMichelinVista {
    public function render($saldo, $recetasEnVenta) {
        ob_start();
        ?>
        <link rel="stylesheet" href="CSS/index.css">
        <link rel="stylesheet" href="CSS/estrellaMichelin.css">

        <h1> Estrella Michelin </h1>
        <h2> Saldo: <?= htmlspecialchars($saldo) ?> </h2>

        <div class="crear-receta-container">
            <a href="crearReceta.php" class="boton-crear" id="botonCrearReceta">Crear Receta</a>
        </div>

        <section class="En venta">
            <h2>Recetas en venta</h2>
            <div class="contenedor-flechas">
                <button id="prevOferta" type="button" class="boton-flecha">&lt;</button>
                <div id="ofertaDestacada" class="contenido">
                    <?php foreach ($recetasEnVenta as $receta): ?>
                        <div class="receta">
                            <h3><?= htmlspecialchars($receta->getTitulo()) ?></h3>
                            <p><?= htmlspecialchars($receta->getDescripcion()) ?></p>
                            <p><strong>Precio: <?= htmlspecialchars($receta->getPrecio()) ?>€</strong></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button id="nextOferta" type="button" class="boton-flecha">&gt;</button>
            </div>
        </section>

        <script src="JS/estrellaMichelinChef.js"></script>
        <?php
        return ob_get_clean();
    }
}

?>
