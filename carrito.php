<?php
require_once("includes/config.php");

$tituloPagina = 'Carrito de Compras';

$carrito = [
    ["nombre" => "Receta de Pasta", "precio" => 12.99, "cantidad" => 1],
    ["nombre" => "Ensalada Fresca", "precio" => 8.50, "cantidad" => 2],
    ["nombre" => "Postre de Chocolate", "precio" => 6.75, "cantidad" => 1]
];

ob_start();
?>
    <!-- Pagina de ejemplo. No tiene ninguna utilidad para la entrega de esta practica -->
    <link rel="stylesheet" href="CSS/carrito.css">
    <h1>Carrito de Compras</h1>
    <div id="carrito-container">
        <table>
            <tr>
                <th>Receta</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>
            <?php foreach ($carrito as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombre']) ?></td>
                    <td><?= number_format($item['precio'], 2) ?> €</td>
                    <td><?= $item['cantidad'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php
$contenidoPrincipal = ob_get_clean();

require("includes/comun/plantilla.php");
