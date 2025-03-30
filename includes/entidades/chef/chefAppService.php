<?php

namespace es\ucm\fdi\aw\entidades\chef;

class chefAppService
{
    private static $instance; // Variable estática para almacenar la única instancia de la clase (patrón Singleton)

    // Método para obtener la única instancia de la clase (Singleton).
    public static function GetSingleton()
    {
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }
  
    // Constructor privado para evitar la creación de instancias fuera de la clase (Singleton).
    private function __construct()
    {
    } 

    public function crearChef($chefDTO)
    {
        $IChefDAO = chefFactory::createChef();
        return $IChefDAO->crearChef($chefDTO);
    }

    public function editarChef($chefDTO)
    {
        $IChefDAO = chefFactory::createChef();
        return $IChefDAO->editarChef($chefDTO);
    }

    public function borrarChef($chefDTO)
    {
        $IChefDAO = chefFactory::createChef();
        return $IChefDAO->borrarChef($chefDTO);
    }

    public function informacionChef($userDTO)
    {
        $IChefDAO = chefFactory::createChef();
        return $IChefDAO->informacionChef($userDTO);
    }

}

?>