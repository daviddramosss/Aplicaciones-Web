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
            <a href="crearReceta.php" class="boton_ayuda_cabecera">
              <img src="img/informacion.png" alt="Ayuda">
            </a>
            
            <a href="buscar.php" class="lupa_cabecera">
              <img src="img/busqueda-de-lupa.png" alt="Buscar">
            </a>
           
            <h2 class="market"> Market </h2>

            <!-- Logo -->
            <a href="index.php" class="logo_cabecera">
              <img src="img/Logo.png" alt="Home">
            </a>
            
            <h2 class="chef"> Chef </h2>

            <!-- Buscador -->
            <a href="estrellaMichelin.php" class="estrella_cabecera">
              <img src="img/estrella_michelin.png" alt="Estrella Michelin">
            </a>
            
            <a href="carrito.php" class="carrito_cabecera">
              <img src="img/carrito.png" alt="Carrito">
            </a>
            
           <!-- Icono de usuario con menú desplegable -->
            <div class="usuario_desplegable_cabecera">
                <img src="img/usuario.png" alt="Usuario">
                     
            </div>
            <div class="menu_usuario">
              <?php if (isset($_SESSION['usuario'])): ?>
                  <a href="perfil.php">Mi Perfil</a>
                  <a href="logout.php">Cerrar Sesión</a>
              <?php else: ?>
                  <a href="login.php">Iniciar Sesión</a>
                  <a href="register.php">Registrarse</a>
              <?php endif; ?>
              </div>


    </header>
    <script src="JS/desplegable_perfil.js"></script>
</body>
</html>
