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
        
        if ($datos) 
        {
            $nombreUsuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : $nombreUsuario;
        }

        $html = <<<EOF
        <fieldset>
            <legend>Usuario y contraseña</legend>
            <p><label>Nombre:</label> <input type="text" name="nombreUsuario" value="$nombreUsuario"/></p>
            <p><label>Password:</label> <input type="password" name="password" /></p>
            <p><label>Re-Password:</label> <input type="password" name="rePassword" /></p>
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
            $userDTO = new userDTO(0, $nombreUsuario, $password);

            $userAppService = userAppService::GetSingleton();

            $createdUserDTO = $userAppService->create($userDTO);

            if ( ! $createdUserDTO ) 
            {
                $result[] = "Error en el proceso de creación del usuario";
            } 
            else 
            {
                $_SESSION["login"] = true;
                $_SESSION["nombre"] = $nombreUsuario;

                $result = 'index.php';
            }
        }
        return $result;
    }
}