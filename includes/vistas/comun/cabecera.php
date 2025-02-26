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
    <header class="header_cabecera">
        <div class="container_cabecera">
         
            <!-- Botón de Ayuda -->
            <a href="ayuda.php" class="boton_ayuda_cabecera">
              <img src="img/informacion.png" alt="Ayuda">
            </a>
            
            <a href="bucar.php" class="lupa_cabecera">
              <img src="img/busqueda-de-lupa.png" alt="Buscar">
            </a>
           
            <!-- Logo -->
            <a href="index.php" class="logo_cabecera">
              <img src="img/Logo.png" alt="Home">
            </a>
            
            <!-- Buscador -->
            <a href="estrellaMichelin.php" class="estrella_cabecera">
              <img src="img/estrella_michelin.png" alt="Estrella Michelin">
            </a>
            
            <a href="carrito.php" class="carrito_cabecera">
              <img src="img/carrito.png" alt="Carrito">
            </a>
            
            <a href=".php" class="carrito_cabecera">
              <img src="img/carrito.png" alt="Carrito">
            </a>
          
        </div>
    </header>
</body>
</html>
