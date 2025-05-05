<?php

namespace es\ucm\fdi\aw\entidades\usuario; 
include_once __DIR__ . "/../../config.php";
use es\ucm\fdi\aw\application;

// Clase en la que se implementa la lógica y las funciones que se van a usar en relación con los usuarios
// este archivo o script posee capacidad de interacción con la base de datos.
class userDAO implements IUser
{
    // Constructor vacío que permite crear instancias vacías para acceder a sus funciones
    public function __construct()
    {

    }

    // Función login
    // Se encarga de llamar a la función buscaUsuario explicada más abajo, si esta función devuelve un usuario y su contraseña coincide con la del usuario pasado por parámetro, 
    // devuelve al usuario encontrado, en caso contrario, devuelve falso
    public function login($userDTO)
    {
        $foundedUserDTO = $this->buscaUsuario($userDTO->getEmail());
        
        // Comparamos los hashes de las contraseñas
        if ($foundedUserDTO && password_verify($userDTO->getPassword(), $foundedUserDTO->getPassword()))
        {
            return $foundedUserDTO;
        } 

        return false;
    }

    // Función buscarUsuario
    // Se encarga de buscar un usuario en la base de datos en función de su email
    // Si existe, devuelve el usuario encontrado, en caso contrario, devuelve falso
    public function buscaUsuario($email)
    {
        // Accede a la base de datos
        $conn = application::getInstance()->getConexionBd();
        
        // busca en la base de datos un usuario con el email pasado por parámetro
        $query = sprintf("SELECT * FROM usuarios WHERE Email='%s'", $conn->real_escape_string($email));
        
        // obtenemos el resultado de la búsqueda
        $rs = $conn->query($query);
        
        // Si la búsqueda ha encontrado a un usuario entonces:
        if ($rs && $rs->num_rows == 1) 
        {
            $fila = $rs->fetch_assoc();
            
            // Creamos un usuario con los datos del usuario encontrado, liberamos la variable usada, y lo retornamos
            $user = new userDTO($fila['ID'], $fila['Nombre'], $fila['Apellidos'], $fila['Email'], $fila['Rol'], $fila['Password']);

            $rs->free();

            return $user;
        }

        // Si no se ha encontrado ningún usuario con ese email, se devuelve un false
        return false;
    }

    // Función create
    // Se encarga de crear un nuevo usuario en la base de datos
    public function create($userDTO)
    {
        // inicializamos el usuario a crear a falso
        $createdUserDTO = false;
        
        // nos conectamos con la BBDD
        $conn = application::getInstance()->getConexionBd();

        // Guardamos los atributos del usuario que queremos crear en variables
        $nombreUsuario = $conn->real_escape_string($userDTO->getNombre());
        $apellidosUsuario = $conn->real_escape_string($userDTO->getApellidos());
        $emailUsuario = $conn->real_escape_string($userDTO->getEmail());
        $passwordUsuario = $conn->real_escape_string($userDTO->getPassword());
        $rolUsuario = $conn->real_escape_string($userDTO->getRol());

        // Buscamos primero si existe un usuario con el email del que queremos crear. Si existe, devolvemos false y no lo creamos
        $foundedUserDTO = $this->buscaUsuario($emailUsuario);
        if($foundedUserDTO){
            return false;
        }

        // Si no existe, creamos la sentencia a ejecutar en la BBDD (la query de insert)
        $query = sprintf("INSERT INTO usuarios(Nombre, Apellidos, Email, Rol, Password) VALUES ('%s', '%s', '%s', '%s', '%s')"
            , $nombreUsuario
            , $apellidosUsuario
            , $emailUsuario
            , $rolUsuario
            , $passwordUsuario
        );

        // Si la ejecución del insert se hizo correctamente, cogeremos el id asignado automáticamente por la BBSDD y crearemos el usuario con los datos para devolverlo
        if ( $conn->query($query) ) 
        {
            $idUser = $conn->insert_id;
            
            $createdUserDTO = new userDTO($idUser, $nombreUsuario, $apellidosUsuario, $emailUsuario, $rolUsuario, $passwordUsuario );
        } 

        return $createdUserDTO;
    }

}
?>