<?php
// cabecera.php - Archivo de cabecera con banner, buscador y botón de ayuda
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabecera</title>
    <link rel="stylesheet" href="CSS/cabecera.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <!-- Logo -->
            <a href="index.php" class="logo">MiLogo</a>
            
            <!-- Buscador -->
            <form class="search-form" action="buscar.php" method="GET">
                <input class="search-input" type="search" placeholder="Buscar..." name="q" aria-label="Buscar">
                <button class="search-button" type="submit">Buscar</button>
            </form>
            
            <!-- Botón de Ayuda -->
            <a href="ayuda.php" class="help-button">Ayuda</a>
        </div>
    </header>
</body>
</html>
