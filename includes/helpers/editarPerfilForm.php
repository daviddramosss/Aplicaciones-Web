<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\comun\formularioBase;
use es\ucm\fdi\aw\entidades\usuario\{userAppService, userDTO};
use es\ucm\fdi\aw\application;

// Clase editarPerfilForm para editar usuarios existentes y logueados
class editarPerfilForm extends formularioBase
{
    private $userDTO;
    private $userService;
    
    public function __construct() 
    {
        parent::__construct('editarPerfilForm');
    }

    public function init()
    {
        $app = application::getInstance();

        $this->userService = userAppService::GetSingleton();
        
        // Obtener el usuario logueado desde la base de datos
        $this->userDTO = $this->userService->buscarUsuario(new userDTO(null, null, null, $app->getEmail(), null, null, null));

        
    }

    // Método para generar los campos del formulario con los datos actuales
    protected function CreateFields($datos)
    {
        if($this->userDTO == false){
            header("Location: login.php");
            exit();
        }
        $nombre = $this->userDTO->getNombre();
        $apellidos = $this->userDTO->getApellidos();

        $rutaImagen = "img/perfiles/" . htmlspecialchars($this->userDTO->getRuta());     

        // Generamos el formulario con los valores actuales para edición
        // Generación del HTML para el formulario
        $html = <<<EOF
            <div class="input-container">
                <input type="textarea" name="nombre" placeholder="NOMBRE" value="$nombre" required/>
            </div>
            
            <div class="input-container">
                <input type="textarea" name="apellidos" placeholder="APELLIDOS" value="$apellidos" required/>
            </div>
            
            <button type="button" class="send-button" name="cambiarPassword">CAMBIAR CONTRASEÑA</button>
            <div id="passwords-container" class="passwords-container"></div>


            <h2>Foto de perfil</h2>
            <img src="$rutaImagen" alt="$nombre" style="width: 200px">
            <input type="file" id="imagenUsuario" name="imagenUsuario" accept="image/jpeg, image/png, image/gif"/>

            <div id="previewContainer">
                <img id="previewImage" src="" alt="Vista previa de la imagen" style="display: none;"/>
            </div>

            <!-- Botones de acción -->
            <p>
                <button type="button" class="send-button" onclick="location.href='index.php'">CANCELAR</button>
                <button type="submit" class="send-button" name="guardar">GUARDAR</button>
            </p>      
            <script src="JS/editarPerfil.js"></script>   
        EOF;

        return $html;
    }

    // Método que maneja el procesamiento de la edición al enviar el formulario
    protected function Process($datos)
    {
        $result = array();
             
        // Saneamiento de datos de entrada
        $nombre = htmlspecialchars(trim($datos['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
        $apellidos = htmlspecialchars(trim($datos['apellidos'] ?? ''), ENT_QUOTES, 'UTF-8');
        
        $antiguaPass = htmlspecialchars(trim($datos['antiguaPassword'] ?? ''), ENT_QUOTES, 'UTF-8');
        $nuevaPass = htmlspecialchars(trim($datos['password'] ?? ''), ENT_QUOTES, 'UTF-8');
        $rePass = htmlspecialchars(trim($datos['rePassword'] ?? ''), ENT_QUOTES, 'UTF-8');
  
        // Validaciones
        if (empty($nombre) || empty($apellidos)) {
            $result[] = "Error: Los campos de nombre y apellidos son obligatorios.";
        }

        if($antiguaPass !== "" || $nuevaPass !== "" || $rePass !== ""){

            if (!password_verify($antiguaPass, $this->userDTO->getPassword())){
                $result[] = "Error: La contraseña actual no coincide.";
            } 
            
            if ($nuevaPass !== $rePass){
                $result[] = "Error: Las nuevas contraseñas no coinciden.";
            }
        }
        
        $imagenGuardada = $this->procesarImagen($this->userDTO);
        
        if ($imagenGuardada === null) {
            $result[] = "Error: La imagen subida no es válida.";
        }
       

        // Si no hay errores, actualizar la receta
        if (count($result) === 0)
        {      

            // guardamos el hash de su contraseña en una variable
            if($nuevaPass !== ""){
                
                $hashedPassword = password_hash($nuevaPass, PASSWORD_BCRYPT);
    
                // Crear un objeto DTO con los nuevos valores
                $userDTO = new userDTO($this->userDTO->getId(), $nombre, $apellidos, null, null, $hashedPassword, $imagenGuardada);
            }
            else{
                // Crear un objeto DTO con los nuevos valores
                $userDTO = new userDTO($this->userDTO->getId(), $nombre, $apellidos, null, null, $this->userDTO->getPassword(), $imagenGuardada);
            }

           
            $this->userService->editarPerfil($userDTO);
            
            // Redirigir a la confirmación de actualización si tuvo éxito
            $result = 'confirmacionPerfilEditado.php';
        }

        return $result;
    }

    // Método para definir el encabezado de la página
    protected function Heading()
    {
        return '<h1>Editar Perfil</h1>';
    }

    private function procesarImagen($userDTO)
    {
        //A implementar. Comprobar si se ha subido una imagen y de ser asi asegurarse de que se suba bien
        // Si no se ha subido ninguna imagen, asignamos la imagen por defecto
        if (!isset($_FILES['imagenUsuario']) || $_FILES['imagenUsuario']['error'] === UPLOAD_ERR_NO_FILE) {
            return $userDTO->getRuta(); // Retorna la imagen existente   
        }
    
        // Comprobar si hubo un error al subir la imagen
        if ($_FILES['imagenUsuario']['error'] !== UPLOAD_ERR_OK) {
            return null; // Error en la subida
        }
    
        $this->eliminarImagen($userDTO->getRuta());

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

    private function eliminarImagen($nombreImagen)
    {
        if (!$nombreImagen || $nombreImagen === 'avatar_ejemplo.jpg') {
            // No borres si no hay imagen o es la imagen por defecto
            return;
        }

        $rutaImagen = dirname(dirname(__DIR__)) . "/img/perfiles/" . $nombreImagen;

        if (file_exists($rutaImagen)) {
            unlink($rutaImagen); // Borra la imagen
        }
    }

}
