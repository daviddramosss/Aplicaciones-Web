<?php

require_once("includes/config.php");
require_once("includes/usuario/userAppService.php");


$email_usuario = $_SESSION["usuario"];

$userAppService = userAppService::GetSingleton();
$user = $userAppService->buscarUsuario($email_usuario);

$tituloPagina = 'Mi perfil';

$contenidoPrincipal = <<<EOS
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    
</head>
<body>
    <div class="container mt-5">
        <div class="card mx-auto" style="width: 25rem;">
            <!-- Aquí debería ir la imagen de perfil del usuario -->
            <img src="img/avatar_ejemplo.jpg" style="width: 100px"  class="card-img-top" alt="Avatar">
            <div class="card-body">
                <!-- Aquí va el nombre del usuario obtenido de la base de datos -->
                <h2 class="card-title">Hola, {$user->nombre()}, {$user->apellidos()}</h2>
                <!-- Aquí va el correo electrónico del usuario -->
                <p class="card-text"><strong>Email:</strong> {$user->email()}</p>
                <p class="card-text"><strong>Rol:</strong> {$user->rol()}</p>

                <a href="editar_perfil.php" class="btn btn-primary">Editar Perfil</a>
                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
EOS;

require("includes/comun/plantilla.php");
?>
