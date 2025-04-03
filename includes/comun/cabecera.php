<?php

// Este es el script de Cabecera, en el que está el código usado para mostrar la cabecera y sus elementos
require_once(__DIR__ . "/../config.php");
use es\ucm\fdi\aw\entidades\usuario\{UserDTO, userAppService};
use es\ucm\fdi\aw\application;

// Comprobamos si el usuario está logueado, y qué tipo de rol tiene
$application = application::getInstance();

// Declaramos varias variables que nos van a ser útiles para distinguir lo que mostrar o no mostrar en la cabecera
$esAdmin = false;
$esChef =false;

$logged = $application->isLogged();

  if ($logged) {
    $userAppService = userAppService::GetSingleton(); // llamamos a la Singleton de userAppService y la guardamos en una variable para hacerla accesible
    $foundedUserDTO = $userAppService->buscarUsuario(new UserDTO(null, null, null, $application->getEmail(), null, null, null)); // Buscamos el usuario que está logueado mediante su email ($application->getEmail()); // Buscamos el usuario que está logueado mediante su email

    if($foundedUserDTO){  // Si existe, vemos su rol
        if ($foundedUserDTO->getRol() == "Admin") {
            $esAdmin = true;
          }
    }
  } 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabecera</title>
</head>
<body>
        <div class="container_cabecera">  <!-- Creamos el div en el que estará todo el contenido de la cabecera -->
         
          <div class="container_infosearch">
             <!-- Botón de Ayuda -->
             <a href="informacion.php" class="boton_ayuda_cabecera">
              <img src="img/informacion.png" alt="Ayuda">
            </a>
            
             <!-- Botón de Buscar -->
            <a href="buscar.php" class="lupa_cabecera">
              <img src="img/busqueda-de-lupa.png" alt="Buscar">
            </a>

            <!-- Si es Admin, mostramos un botón concreto para él -->
            <?php if ($esAdmin): ?>
               <!-- Icono de admin con su menú desplegable -->
              <div class="admin_desplegable_cabecera">
                  <img src="img/editar.png" alt="Admin">    
              </div>

               <!-- Opciones dentro del menú desplegable del admin -->
              <div class="menu_admin">
                    <a href="gestionarUsuarios.php">Gestionar usuarios</a>
                    <a href="gestionarIngredientes.php">Gestionar ingredientes</a>    
              </div>
            <?php endif; ?>
          </div>
           
          <div class="container_titulo">
              <!-- Palabra Market -->
              <h1 class="market"> Market </h1>

              <!-- Logo -->
              <a href="index.php" class="logo_cabecera">
                <img src="img/Logo.png" alt="Home">
              </a>

              <!-- Palabra chef -->
              <h1 class="chef"> Chef </h1>
          </div>
             
          <div class="container_users">
            <!-- Comprobamos si el usuario está logueado, sino, el botón de estrella michelin no es accesible y redirige al login -->

            <?php if (!$logged): ?>
              <a href="login.php" class="estrella_cabecera">
                <img src="img/estrella_michelin.png" alt="Estrella Michelin No Chef">
              </a>

            <?php else: ?>
                
              <!-- Si está logueado, lo mandamos a la clase de estrella michelin -->
                <a href="estrellaMichelin.php" class="estrella_cabecera"> 
                  <img src="img/estrella_michelin.png" alt="Estrella Michelin">
                </a>
            <?php endif; ?>                        
              
             <!-- Botón de carrito -->
            <a href="carrito.php" class="carrito_cabecera">
              <img src="img/carrito.png" alt="Carrito">
            </a>            
           
           <!-- Icono de usuario con menú desplegable -->
            <div class="usuario_desplegable_cabecera">
                <img src="img/usuario.png" alt="Usuario">      
            </div>

            <div class="menu_usuario">
               <!-- Si el usuario está logueado, mostramos el acceso a su información -->
              <?php if ($logged): ?>
                  <a href="perfil.php">Mi Perfil</a>
                  <a href="despensa.php">Mi Despensa</a>
                  <a href ="recetario.php">Mi Recetario</a>
                  <a href="logout.php">Cerrar Sesión</a>
              <!-- Si el usuario no está logueado, mostramos iniciar sesión y registro -->
              <?php else: ?>
                  <a href="login.php">Iniciar Sesión</a>
                  <a href="register.php">Registrarse</a>
              <?php endif; ?>
            </div>

        </div>
      </div>
             
          
     <!-- Scripts que permiten hacer los desplegables -->
    <script src="JS/desplegable_perfil.js"></script>
    <script src="JS/desplegable_admin.js"></script>
</body>
</html>
