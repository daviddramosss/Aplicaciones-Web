<?php

require_once("recetaFactory.php"); 

class recetaAppService
{
    private static $instance; 

    // Método estático que devuelve la única instancia de la clase (patrón Singleton)
    public static function GetSingleton()
    {
        // Si no se ha creado una instancia de la clase, la crea
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        // Retorna la instancia única de la clase
        return self::$instance;
    }
  
    // Constructor privado para evitar instanciaciones directas
    private function __construct()
    {
    } 

    // Método para crear una receta
    public function crearReceta($recetaDTO, $ingredientes, $etiquetas)
    {
        // Crea el objeto IRecetaDAO utilizando la fábrica (factory)
        $IRecetaDAO = recetaFactory::CreateReceta();

        // Llama al método 'crearReceta' del DAO para insertar la receta en la base de datos
        $createdRecetaDTO = $IRecetaDAO->crearReceta($recetaDTO, $ingredientes, $etiquetas);

        $id = $createdRecetaDTO->getId();

        // Guarda los ingredientes relacionados con la receta
        $ingredienteRecetaService = ingredienteRecetaAppService::GetSingleton();

        foreach ($ingredientes as $ingredienteId => $ingredienteData) {
            $ingredienteId = intval($ingredienteId);
            $cantidad = floatval($ingredienteData['cantidad'] ?? 0);
            $magnitud = filter_var($ingredienteData['magnitud'] ?? 0, FILTER_VALIDATE_INT);
        
            // Si el ingrediente es válido, lo guarda
            if ($ingredienteId > 0 && $cantidad > 0) {
                $ingredienteRecetaDTO = new ingredienteRecetaDTO($id, $ingredienteId, $cantidad, $magnitud);
                $ingredienteRecetaService->crearIngredienteReceta($ingredienteRecetaDTO);
            }
        }

        // Guarda las etiquetas relacionadas con la receta
        $etiquetaRecetaService = etiquetaRecetaAppService::GetSingleton();

        $etiquetas = array_slice(array_unique($etiquetas), 0, 3); // Limita a 3 etiquetas únicas
        foreach ($etiquetas as $etiqueta) {
            $etiqueta = filter_var($etiqueta, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Si la etiqueta es válida, la guarda
            if (!empty($etiqueta)) {
                $etiquetaRecetaDTO = new etiquetaRecetaDTO($id, $etiqueta);
                $etiquetaRecetaCreadaDTO = $etiquetaRecetaService->crearEtiquetaReceta($etiquetaRecetaDTO);
            }
        } 

        // Devuelve el objeto DTO creado
        return $createdRecetaDTO;
    }

    // Método para editar una receta
    public function editarReceta($recetaDTO)
    {
        // Crea el objeto IRecetaDAO utilizando la fábrica (factory)
        $IRecetaDAO = recetaFactory::CreateReceta();

        // Llama al método 'editarReceta' del DAO para actualizar la receta en la base de datos
        $editedRecetaDTO = $IRecetaDAO->editarReceta($recetaDTO);

        // Devuelve el objeto DTO editado
        return $editedRecetaDTO;
    }

    // Método para borrar una receta
    public function borrarReceta($recetaDTO)
    {
        // Crea el objeto IRecetaDAO utilizando la fábrica (factory)
        $IRecetaDAO = recetaFactory::CreateReceta();

        // Llama al método 'borrarReceta' del DAO para eliminar la receta de la base de datos
        $deletedRecetaDTO = $IRecetaDAO->borrarReceta($recetaDTO);

        // Devuelve el objeto DTO borrado
        return $deletedRecetaDTO;
    }

}

?>
