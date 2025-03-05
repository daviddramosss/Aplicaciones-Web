<?php

$esAdmin = false;
$esChef =false;
require_once("includes/usuario/userAppService.php");

// Comprobamos si el usuario está logueado y tiene el rol de Admin
if (isset($_SESSION["login"])) {
  $userAppService = userAppService::GetSingleton();
  $foundedUserDTO = $userAppService->buscarUsuario($_SESSION["usuario"]);

  if($foundedUserDTO){
      if ($foundedUserDTO->rol() == "Admin") {
          $esAdmin = true;
        }
        //añadido nico
      if ($foundedUserDTO->rol() == "Chef") {
            $esChef = true;
      }

    }

}

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

            
            
            <?php if ($esAdmin): ?>
<<<<<<< HEAD
              <!--INCLUIR BOTÓN EXCLUSIVO DEL ADMIN -->
              <a href="gestionarUsuarios.php" class="editar_cabecera"> 
              <img src="img/editar.png" alt="Panel Admin">
              </a>
=======
               <!-- Icono de admin con menú desplegable -->
              <div class="admin_desplegable_cabecera">
                  <img src="img/editar.png" alt="Admin">
                      
              </div>
              <div class="menu_admin">
                    <a href="gestionarUsuarios.php">Gestionar usuarios</a>
                    <a href="gestionarIngredientes.php">Gestionar ingredientes</a>
                    
                </div>
>>>>>>> 90fbee8826d0b0e8bf5381a96a79e2c4be5c9f11
              
            <?php endif; ?>

            <!-- Buscador -->

            <?php if (!$esChef): ?>

            <a href="estrellaMichelinNoChef.php" class="estrella_cabecera">
              <img src="img/estrella_michelin.png" alt="Estrella Michelin No Chef">
            </a>

            <?php endif; ?>


            <?php if ($esChef): ?>
             
              <a href="estrellaMichelinChef.php" class="estrella_cabecera"> 
              <img src="img/estrella_michelin.png" alt="Estrella Michelin Chef">
              </a>

            <?php endif; ?>
            
            <a href="carrito.php" class="carrito_cabecera">
              <img src="img/carrito.png" alt="Carrito">
            </a>
            
           
           <!-- Icono de usuario con menú desplegable -->
            <div class="usuario_desplegable_cabecera">
                <img src="img/usuario.png" alt="Usuario">
                     
            </div>
            <div class="menu_usuario">
              <?php if (isset($_SESSION['login'])): ?>
                  <a href="perfil.php">Mi Perfil</a>
                  <a href="despensa.php">Mi Despensa</a>
                  <a href ="recetario.php">Mi Recetario</a>
                  <a href="logout.php">Cerrar Sesión</a>
                 
              <?php else: ?>
                  <a href="login.php">Iniciar Sesión</a>
                  <a href="register.php">Registrarse</a>
              <?php endif; ?>
              </div>


    </header>
    <script src="JS/desplegable_perfil.js"></script>
    <script src="JS/desplegable_admin.js"></script>
</body>
</html>
