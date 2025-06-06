<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\usuario\{userDTO, userAppService};
use es\ucm\fdi\aw\comun\formularioBase;

class registerForm extends formularioBase
{
    // Constructor de la clase
    public function __construct() 
    {
        parent::__construct('registerForm');
    }
    
    // Método protegido que crea los campos del formulario 
    protected function CreateFields($datos)
    {
        // creamos variables vacías para precargar los campos con ellas
        $nombreUsuario = '';
        $apellidosUsuario = '';
        $email = '';
        
        // si el usuario viene de un registro fallido, tendremos guardados sus datos previamente introducidos, por lo que, si existen, los guardamos en las variables definidas para ello
        if ($datos) 
        {
            $nombreUsuario = $datos['nombreUsuario'] ?? $nombreUsuario;
            $apellidosUsuario = $datos['apellidosUsuario'] ?? $apellidosUsuario;
            $email = $datos['email'] ?? $email;
        } 

        // Generación del HTML para el formulario
        $html = <<<EOF
            <div class="input-container">
                <input type="text" name="nombreUsuario" placeholder="NOMBRE" value="$nombreUsuario" required/>
            </div>
            
            <div class="input-container">
                <input type="text" name="apellidosUsuario" placeholder="APELLIDOS" value="$apellidosUsuario" required/>
            </div>
            
            <div class="input-container">
                <input type="text" name="email" placeholder="EMAIL" value="$email" required/>
            </div>
            
            <div class="input-container">
                <input type="password" name="password" placeholder="CONTRASEÑA" required/>
            </div>
            
            <div class="input-container">
                <input type="password" name="rePassword" placeholder="REPETIR CONTRASEÑA" required/>
            </div>
            
            <!-- Sección de imagen -->
            <h2>Foto de perfil</h2>
            <p><label for="imagenUsuario">Sube una foto de perfil. Si no sube ninguna imagen, se usara la imagen por defecto.</label></p>
            <input type="file" id="imagenUsuario" name="imagenUsuario" accept="image/jpeg, image/png, image/gif"/>

            <div id="previewContainer">
                <img id="previewImage" src="" alt="Vista previa de la imagen" style="display: none;"/>
            </div>


            <button type="submit" class="send-button" name="register">REGISTRARSE</button>

            <!-- Importación de scripts JavaScript -->
            <script src="JS/register.js"></script>
            
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
        $imagenGuardada = $this->procesarImagen();

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

        if ($imagenGuardada === null) {
            $result[] = "Error: La imagen subida no es válida.";
        }

        // si no ha habido errores, intentamos registrar al usuario
        if (count($result) === 0) 
        {
            // guardamos el hash de su contraseña en una variable
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // creamos el usuario con los datos introducidos y un id 0 que será insignificante porque la BBDD le asignará el que le corresponde
            $userDTO = new userDTO(0, $nombreUsuario, $apellidosUsuario, $email, "User", $hashedPassword, $imagenGuardada);
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
                $_SESSION["id"] = $createdUserDTO->getId();
                // lo redirigimos a la pantalla de inicio
                $result = 'index.php';
            }
        }
        // devolvemos o bien los errores, o bien la pantalla de inicio
        return $result;
    }

    protected function Heading()
    {
        $html = '<h1>Registrar nuevo usuario</h1>';
        $html .= '<div> <img src="img/LogoRegistro.png" alt="LogoRegistro" style="width: 150px; height: auto;"> </div>';
        return $html;
    }

    
    private function procesarImagen()
    {
        // Si no se ha subido ninguna imagen, asignamos la imagen por defecto
        if (!isset($_FILES['imagenUsuario']) || $_FILES['imagenUsuario']['error'] === UPLOAD_ERR_NO_FILE) {
            return "avatar_ejemplo.jpg";
        }
    
        // Comprobar si hubo un error al subir la imagen
        if ($_FILES['imagenUsuario']['error'] !== UPLOAD_ERR_OK) {
            return null; // Error en la subida
        }
    
        $imagenTmp = $_FILES['imagenUsuario']['tmp_name'];
        $nombreOriginal = $_FILES['imagenUsuario']['name'];
    
        // Obtener la extensión del archivo
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
    
        // Validar formato de imagen (solo JPG, PNG, GIF)
        $formatosPermitidos = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $formatosPermitidos)) {
            return null; // Formato no permitido
        }
    
        // Generar un nombre único para evitar duplicados
        $nombreImagen = uniqid("perfil_") . "." . $extension;
    
        // Definir la ruta de destino
        $directorioDestino = dirname(dirname(__DIR__)) . "/img/perfiles/";
    
        // Ruta completa donde se guardará la imagen
        $rutaFinal = $directorioDestino . $nombreImagen;
    
        // Guardar la imagen en el servidor
        if (!move_uploaded_file($imagenTmp, $rutaFinal)) {
            return null; // Error al guardar la imagen
        }
    
        return $nombreImagen; // Devolver el nombre de la imagen guardada
    }
    
}
