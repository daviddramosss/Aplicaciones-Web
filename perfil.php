<?php

require_once("includes/config.php");
require_once("includes/entidades/usuario/userAppService.php");

// Guardamos el email del usuario que está logueado
$email_usuario = $_SESSION["usuario"];

// Creamos la instancia del userAppService y la usamos para obtener todos los datos del usuario logueado
$userAppService = userAppService::GetSingleton();
$user = $userAppService->buscarUsuario($email_usuario);

$tituloPagina = 'Mi perfil';

// contenido guardado en la variable dinámica de la plantilla
$contenidoPrincipal = <<<EOS
<body>
    <div class="container mt-5">
        <div class="card mx-auto" style="width: 25rem;">
            <img src="img/avatar_ejemplo.jpg" style="width: 100px"  class="card-img-top" alt="Avatar">
            <div class="card-body">
                <!-- Aquí va el nombre y los apellidos del usuario obtenido de la base de datos -->
                <h2 class="card-title">Hola, {$user->getNombre()}, {$user->getApellidos()}</h2>
                <!-- Aquí va el correo electrónico del usuario -->
                <p class="card-text"><strong>Email:</strong> {$user->getEmail()}</p>
                <!-- Aquí va el rol del usuario -->
                <p class="card-text"><strong>Rol:</strong> {$user->getRol()}</p>
                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
EOS;

require("includes/comun/plantilla.php");
?>
