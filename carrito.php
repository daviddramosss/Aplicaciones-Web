<?php

// Se incluye el archivo de configuración general del proyecto
require_once("includes/config.php");

// Se define el título de la página
$tituloPagina = 'Carrito de Compras';

// Datos del carrito de compras (simulación hasta ahora)
$carrito = [
    ["nombre" => "Receta de Pasta", "precio" => 12.99, "cantidad" => 1],
    ["nombre" => "Ensalada Fresca", "precio" => 8.50, "cantidad" => 2],
    ["nombre" => "Postre de Chocolate", "precio" => 6.75, "cantidad" => 1]
];

// Se comienza a generar el contenido dinámico de la página
$contenidoPrincipal = <<<EOS
    <link rel="stylesheet" href="CSS/carrito.css">
    <h1>Carrito de Compras</h1>
    <div id="carrito-container">
        <table>
            <tr>
                <th>Receta</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>
EOS;

// Se recorre el carrito para mostrar cada uno de los productos
foreach ($carrito as $item) {
    $contenidoPrincipal .= "
            <tr>
                <td>" . htmlspecialchars($item['nombre']) . "</td>
                <td>" . number_format($item['precio'], 2) . " €</td>
                <td>" . $item['cantidad'] . "</td>
            </tr>
    ";
}

// Se cierra la tabla y el contenedor
$contenidoPrincipal .= <<<EOS
        </table>
    </div>
EOS;

// Se incluye el archivo plantilla.php que manejará el layout y el HTML común
require("includes/comun/plantilla.php");

?>
