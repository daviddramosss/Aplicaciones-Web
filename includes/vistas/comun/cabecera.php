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
          <div class="left-icons">

           <!-- Botón de Ayuda -->
          <a href="ayuda.php" class="boton_ayuda_cabecera">
            <img src="img/informacion.png" alt="Ayuda">
            </a>

            <a href="bucar.php" class="lupa_cabecera"><img src="img/busqueda-de-lupa.png" alt="Buscar"></a>
          </div>
           
            

           <!-- Buscador -->
           <form class="search-form_cabecera" action="buscar.php" method="GET">
                <input class="search-input_cabecera" type="search" placeholder="Buscar..." name="q" aria-label="Buscar">
                <button class="search-button_cabecera" type="submit">Buscar</button>
            </form>

            <!-- Logo -->
            <a href="index.php" class="logo_cabecera">
            <img src="img/Logo.png" alt="Home">
            </a>
            
           
            
          
        </div>
    </header>
</body>
</html>
