<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$email_usuario = $_SESSION["usuario"];

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
            <img src="RUTA_DE_LA_IMAGEN" class="card-img-top" alt="Avatar">
            <div class="card-body">
                <!-- Aquí va el nombre del usuario obtenido de la base de datos -->
                <h5 class="card-title">Hola, NOMBRE_USUARIO!</h5>
                <!-- Aquí va el correo electrónico del usuario -->
                <p class="card-text"><strong>Email:</strong> {$email_usuario}</p>
                <!-- Aquí va la fecha de registro del usuario -->
                <p class="card-text"><strong>Fecha de registro:</strong> FECHA_REGISTRO</p>
                
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
