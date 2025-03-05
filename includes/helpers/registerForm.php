<?php

include __DIR__ . "/../comun/formularioBase.php";
include __DIR__ . "/../usuario/userAppService.php";

class registerForm extends formularioBase
{
    public function __construct() 
    {
        parent::__construct('registerForm');
    }
    
    protected function CreateFields($datos)
    {
        $nombreUsuario = '';
        $apellidosUsuario = '';
        $email = '';
        
        if ($datos) 
        {
            $nombreUsuario = $datos['nombreUsuario'] ?? $nombreUsuario;
            $apellidosUsuario = $datos['apellidosUsuario'] ?? $apellidosUsuario;
            $email = $datos['email'] ?? $email;
        } 

        $html = <<<EOF
        <fieldset>
            <legend>Crea tu cuenta</legend>
            <p><label>Nombre:</label> <input type="text" name="nombreUsuario" value="$nombreUsuario"/></p>
            <p><label>Apellidos:</label> <input type="text" name="apellidosUsuario" value="$apellidosUsuario"/></p>
            <p><label>Email:</label> <input type="text" name="email" value="$email"/></p>
            <p><label>Contraseña:</label> <input type="password" name="password" /></p>
            <p><label>Repetir Contraseña:</label> <input type="password" name="rePassword" /></p>
            <button type="submit" name="register">Registrarse</button>
        </fieldset>
EOF;
        return $html;
    }
    
    protected function Process($datos)
    {
        $result = [];

        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $apellidosUsuario = trim($datos['apellidosUsuario'] ?? '');
        $email = trim($datos['email'] ?? '');
        $password = trim($datos['password'] ?? '');
        $rePassword = trim($datos['rePassword'] ?? '');

        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $apellidosUsuario = filter_var($apellidosUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($nombreUsuario)) {
            $result[] = "El nombre de usuario no puede estar vacío.";
        }

        if (empty($apellidosUsuario)) {
            $result[] = "Los apellidos del usuario no pueden estar vacíos.";
        }

        if (empty($email)) {
            $result[] = "El email no puede estar vacío.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result[] = "El email no es válido.";
        }

        if (empty($password)) {
            $result[] = "La contraseña no puede estar vacía.";
        }

        if ($password !== $rePassword) {
            $result[] = "Las contraseñas no coinciden.";
        }

        if (count($result) === 0) 
        {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $userDTO = new userDTO(0, $nombreUsuario, $apellidosUsuario, $email, "User", $hashedPassword, null, null);
            $userAppService = userAppService::GetSingleton();
            $createdUserDTO = $userAppService->create($userDTO);

            if (!$createdUserDTO) {
                $result[] = "Ya hay un usuario con ese email, por favor utiliza otro email";
            } else {
                $_SESSION["login"] = true;
                $_SESSION["usuario"] = $email;
                $result = 'index.php';
            }
        }

        return $result;
    }
}
