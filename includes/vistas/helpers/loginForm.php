<?php

include __DIR__ . "/../../comun/formularioBase.php";
include __DIR__ . "/../../usuario/userAppService.php";

class loginForm extends formularioBase
{
    public function __construct() 
    {
        parent::__construct('loginForm');
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
            <p><label>Email:</label> <input type="text" name="nombreUsuario" value="$nombreUsuario"/></p>
            <p><label>Password:</label> <input type="password" name="password" /></p>
            <button type="submit" name="login">Entrar</button>
        </fieldset>
EOF;
        return $html;
    }
    

    protected function Process($datos)
    {
        $result = array();
        
        //filter_var vs htmlspecialchars(trim(strip_tags($_REQUEST["username"])));

        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
        if ( empty($nombreUsuario) ) 
        {
            $result[] = "El email no puede estar vacío";
        }
        
        $password = trim($datos['password'] ?? '');
        
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if ( empty($password) ) 
        {
            $result[] = "El password no puede estar vacío.";
        }
        
        if (count($result) === 0) 
        {
            $userDTO = new userDTO(0, $nombreUsuario, $password);

            $userAppService = userAppService::GetSingleton();

            $foundedUserDTO = $userAppService->login($userDTO);

            if ( ! $foundedUserDTO ) 
            {
                // No se da pistas a un posible atacante
                $result[] = "El email o el password no coinciden";
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