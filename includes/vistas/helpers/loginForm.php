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
        $email = '';
        
        if ($datos) 
        {
            $email = isset($datos['email']) ? $datos['email'] : $email;
        }

        $html = <<<EOF
        <fieldset>
            <legend>Usuario y contraseña</legend>
            <p><label>Email:</label> <input type="text" name="email" value="$email"/></p>
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

        $email = trim($datos['email'] ?? '');
        
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
        if ( empty($email) ) 
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
            $userDTO = new userDTO(0, $email, $password);

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
                $_SESSION["usuario"] = $email;

                $result = 'index.php';
            }
        }
        return $result;
    }
}