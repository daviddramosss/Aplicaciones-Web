<?php

namespace es\ucm\fdi\aw\helpers;
use es\ucm\fdi\aw\entidades\usuario\userAppService;
// require_once(__DIR__ . '/../entidades/usuario/userAppService.php');

class perfilHelper {

    public function generarPerfil() {
        // Verifica si hay un usuario logueado
        if (!isset($_SESSION["usuario"])) {
            return <<<EOS
            <div class="container mt-5 text-center">
                <h2>No has iniciado sesión</h2>
                <p>Por favor, <a href="login.php">inicia sesión</a> para ver tu perfil.</p>
            </div>
            EOS;
        }

        // Obtiene el email del usuario logueado
        $email_usuario = $_SESSION["usuario"];

        // Obtiene los datos del usuario
        $userAppService = userAppService::GetSingleton();
        $user = $userAppService->buscarUsuario($email_usuario);

        // Verifica si el usuario existe en la base de datos
        if (!$user) {
            return <<<EOS
            <div class="container mt-5 text-center">
                <h2>Usuario no encontrado</h2>
                <p>Parece que hay un problema con tu cuenta. Contacta con el soporte.</p>
            </div>
            EOS;
        }

        // Genera el HTML del perfil
        return <<<EOS
        <div class="container mt-5">
            <div class="card mx-auto" style="width: 25rem;">
                <img src="img/avatar_ejemplo.jpg" style="width: 100px" class="card-img-top" alt="Avatar">
                <div class="card-body">
                    <h2 class="card-title">Hola, {$user->getNombre()} {$user->getApellidos()}</h2>
                    <p class="card-text"><strong>Email:</strong> {$user->getEmail()}</p>
                    <p class="card-text"><strong>Rol:</strong> {$user->getRol()}</p>
                    <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
                </div>
            </div>
        </div>
        EOS;
    }
}

?>