<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\comun\formularioBase;
use es\ucm\fdi\aw\entidades\usuario\{userDTO, userAppService};

// archivo en el que encontramos el formulario de login

class loginForm extends formularioBase
{
    // Constructor de la clase
    public function __construct() 
    {
        parent::__construct('loginForm');
    }
    
    // Método protegido que crea los campos del formulario 
    protected function CreateFields($datos)
    {
        $email = '';
        
        // si el usuario ha fallado en el incio de sesión, al volver a cargar la página, le dejaremos el campo de email relleno con su anterior introducción
        if ($datos) 
        {
            $email = isset($datos['email']) ? $datos['email'] : $email;
        }

        // Generación del HTML para el formulario
        $html = <<<EOF
            
                <div class="input-container">
                <input type="text" name="email" placeholder="EMAIL" value="$email" required/>
                </div>

                <div class="input-container">
                <input type="password" name="password" placeholder="CONTRASEÑA" required/>
                </div>
                
                <button type="submit" class="send-button" name="login">ENTRAR</button>
        EOF;

        return $html;
    }
    
    // función que se encarga de procesar los datos que ha insertado el usuario
    protected function Process($datos)
    {
        $result = array();

        // guardamos el email y comprobamos que tiene formato de email
        $email = trim($datos['email'] ?? '');
        
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                
        // si el campo está vacío cuando se intenta acceder, guardamos un error
        if ( empty($email) ) 
        {
            $result[] = "El email no puede estar vacío";
        }
        
        // guardamos la contraseña y comprobamos que está bien escrita
        $password = trim($datos['password'] ?? '');
        
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // si el campo está vacío cuando se intenta acceder, guardamos un error
        if ( empty($password) ) 
        {
            $result[] = "El password no puede estar vacío.";
        }
        
        // si no ha habido ningun error
        if (count($result) === 0) 
        {
            // creamos un usuario con el email y la contraseña pasados por el usuario
            $userDTO = new userDTO(0, '', '', $email, '',$password);

            // creamos la instancia de userAppService y llamamos a la función login
            $userAppService = userAppService::GetSingleton();

            $foundedUserDTO = $userAppService->login($userDTO);

            // Si algo no coincide con la base de datos y no ha podido iniciar sesión, guardamos error
            if ( ! $foundedUserDTO ) 
            {
                // No se da pistas a un posible atacante
                $result[] = "El email o el password no coinciden";
            } 
            else 
            {
                // si ha iniciado sesión, se almacenan los valores relevantes de la sesión
                $_SESSION["login"] = true;
                $_SESSION["usuario"] = $email;

                // se guarda la ruta a la que se debe redirigir al usuario
                $result = 'index.php';
            }
        }
        // devolvemos el array con, o bien los errores, o bien la ruta a la que debemos redirigir al usuario
        return $result;
    }
    protected function Heading()
    {
        $html = '<h1>Inicio de sesión</h1>';
        return $html;
    }
}