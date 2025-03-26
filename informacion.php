<?php

// Se define el título de la página
$tituloPagina = 'Información sobre el proyecto';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <link rel="stylesheet" href="CSS/informacion.css">
    <div class="container">
        <h1>Información</h1>
        <p>Este proyecto se desarrolla exclusivamente con fines académicos para la asignatura de Aplicaciones Web en la Universidad Complutense de Madrid.</p>
        <p>Su propósito es aplicar y demostrar los conocimientos adquiridos en el curso, sin ninguna intención comercial.</p>
        <p>El trabajo se realiza bajo la supervisión del profesor Humberto Javier Cortés Benavides.</p>
    </div>

EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>