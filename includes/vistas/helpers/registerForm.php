<?php

include __DIR__ . "/../../comun/formularioBase.php";
include __DIR__ . "/../../usuario/userAppService.php";

class registerForm extends formularioBase
{
    public function __construct() 
    {
        parent::__construct('registerForm');
    }
    
    protected function CreateFields($datos)
    {
        $nombreUsuario = '';
        $email = '';
        
        if ($datos) 
        {
            $nombreUsuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : $nombreUsuario;
            $email = isset($datos['email']) ? $datos['email'] : $email;
        } 

        $html = <<<EOF
        <fieldset>
            <legend>Crea tu cuenta</legend>
            <p><label>Nombre:</label> <input type="text" name="nombreUsuario" value="$nombreUsuario"/></p>
            <p><label>Apellidos:</label> <input type="text" name="apellidos" /></p>
            <p><label>Email:</label> <input type="text" name="email" /></p>
            <p><label>Contraseña:</label> <input type="password" name="password" /></p>
            <p><label>Repetir Contraseña:</label> <input type="password" name="rePassword" /></p>
            <button type="submit" name="login">Entrar</button>
        </fieldset>
EOF;
        return $html;
    }
    

    protected function Process($datos)
    {
        $result = array();
        
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( empty($nombreUsuario) ) 
        {
            $result[] = "El nombre de usuario no puede estar vacío";
        }

        $email = trim($datos['email'] ?? '');
        
        $email = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( empty($nombreUsuario) ) 
        {
            $result[] = "El nombre de usuario no puede estar vacío";
        }
        
        $password = trim($datos['password'] ?? '');
        
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( empty($password) ) 
        {
            $result[] = "El password no puede estar vacío.";
        }

        $rePassword = trim($datos['rePassword'] ?? '');
        
        $rePassword = filter_var($rePassword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($password !== $rePassword)
        {
            $result[] = "El password no coincide.";
        }
        
        if (count($result) === 0) 
        {
            $userDTO = new userDTO(0, $nombreUsuario, $password, $email, );

            $userAppService = userAppService::GetSingleton();

            $createdUserDTO = $userAppService->create($userDTO);

            if ( ! $createdUserDTO ) 
            {
                $result[] = "Error en el proceso de creación del usuario";
            } 
            else 
            {
                $_SESSION["login"] = true;
                $_SESSION["usuario"] = $nombreUsuario;

                $result = 'index.php';
            }
        }
        return $result;
    }
}