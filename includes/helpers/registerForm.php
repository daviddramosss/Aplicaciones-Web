<?php

include __DIR__ . "/../comun/formularioBase.php";
include __DIR__ . "/../entidades/usuario/userAppService.php";

// archivo en el que encontramos el formulario de registro

class registerForm extends formularioBase
{
    public function __construct() 
    {
        parent::__construct('registerForm');
    }
    
     // función que se encarga de crear los campos en los que el usuario debe introducir sus datos para registrarse
    protected function CreateFields($datos)
    {
        // creamos variables vacías para precargar los campos con ellas
        $nombreUsuario = '';
        $apellidosUsuario = '';
        $email = '';
        
        // si el usuario viene de un registro fallido, tendremos guardados sus datos previamente introducidos, por lo que, si existen, 
        // los guardamos en las variables definidas para ello
        if ($datos) 
        {
            $nombreUsuario = $datos['nombreUsuario'] ?? $nombreUsuario;
            $apellidosUsuario = $datos['apellidosUsuario'] ?? $apellidosUsuario;
            $email = $datos['email'] ?? $email;
        } 

        // creamos los campos
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
    
    // Función que se encarga de procesar los datos que ha introducido el usuario
    protected function Process($datos)
    {
        // creamos el array en el que guardaremos los errores o la ruta de redireccionamiento
        $result = [];

        // guardamos en variables los datos introducidos por el usuario
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $apellidosUsuario = trim($datos['apellidosUsuario'] ?? '');
        $email = trim($datos['email'] ?? '');
        $password = trim($datos['password'] ?? '');
        $rePassword = trim($datos['rePassword'] ?? '');

        // las sanitizamos y comprobamos que no hay nada erróneo
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $apellidosUsuario = filter_var($apellidosUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // si algún campo está vacío, miramos cuál es y guardaremos un error
        if (empty($nombreUsuario)) {
            $result[] = "El nombre de usuario no puede estar vacío.";
        }

        if (empty($apellidosUsuario)) {
            $result[] = "Los apellidos del usuario no pueden estar vacíos.";
        }

        if (empty($email)) {
            $result[] = "El email no puede estar vacío.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // si el email no tiene formato de correo electrónico, guardamos otro error
            $result[] = "El email no es válido.";
        }

        if (empty($password)) {
            $result[] = "La contraseña no puede estar vacía.";
        }

        if ($password !== $rePassword) {
            $result[] = "Las contraseñas no coinciden.";
        }

        // si no ha habido errores, intentamos registrar al usuario
        if (count($result) === 0) 
        {
            // guardamos el hash de su contraseña en una variable
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // creamos el usuario con los datos introducidos y un id 0 que será insignificante porque la BBDD le asignará el que le corresponde
            $userDTO = new userDTO(0, $nombreUsuario, $apellidosUsuario, $email, "User", $hashedPassword, null, null);
            // creamos la instancia de userAppService y llamamos a la función create
            $userAppService = userAppService::GetSingleton();
            $createdUserDTO = $userAppService->create($userDTO);

            // si la función nos ha devuelto un error, un false, es porque ya existe un usuario con ese email, por lo que devolveremos un error
            if (!$createdUserDTO) {
                $result[] = "Ya hay un usuario con ese email, por favor utiliza otro email";
            } else {
                // en caso de que todo haya ido bien, le damos acceso a la web y guardamos los datos importantes de la sesión
                $_SESSION["login"] = true;
                $_SESSION["usuario"] = $email;
                // lo redirigimos a la pantalla de inicio
                $result = 'index.php';
            }
        }
        // devolvemos o bien los errores, o bien la pantalla de inicio
        return $result;
    }
}
