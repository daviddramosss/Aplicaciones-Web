<?php

namespace es\ucm\fdi\aw\entidades\ingrediente;

// Definimos la clase de servicio para gestionar ingredientes
class IngredienteAppService {

    // Variable estática para mantener una única instancia de la clase (patrón Singleton)
    private static $instance;

    // Método estático para obtener la instancia única de la clase
    public static function GetSingleton()
    {
        // Si la instancia no ha sido creada, se crea una nueva
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

    // Constructor privado para evitar la creación de instancias desde fuera de la clase
    private function __construct() 
    {               
    }

    // Método para crear un nuevo ingrediente (aún no implementado)
    public function crearIngrediente($ingredienteDTO)
    {
        // Implementar luego
    }

    // Método para editar un ingrediente existente (aún no implementado)
    public function editarIngrediente($ingredienteDTO)
    {
        // Implementar luego
    }

    // Método para eliminar un ingrediente (aún no implementado)
    public function eliminarIngrediente($ingredienteDTO)
    {
        // Implementar luego
    }
}

