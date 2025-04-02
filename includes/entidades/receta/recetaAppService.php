<?php

namespace es\ucm\fdi\aw\entidades\receta;

use es\ucm\fdi\aw\entidades\ingredienteReceta\{ingredienteRecetaAppService, ingredienteRecetaDTO};
use es\ucm\fdi\aw\entidades\etiquetaReceta\{etiquetaRecetaAppService, etiquetaRecetaDTO};

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
    public function crearReceta($recetaDTO)
    {
        // Crea el objeto IRecetaDAO utilizando la fábrica (factory)
        $IRecetaDAO = recetaFactory::CreateReceta();

        // Llama al método 'crearReceta' del DAO para insertar la receta en la base de datos
        $createdRecetaDTO = $IRecetaDAO->crearReceta($recetaDTO);

        // Devuelve el objeto DTO creado
        return $createdRecetaDTO;
    }

    // Método para editar una receta
    public function editarReceta($recetaDTO, $ingredientes, $etiquetas)
    {
        // Crea el objeto IRecetaDAO utilizando la fábrica (factory)
        $IRecetaDAO = recetaFactory::CreateReceta();

        // Llama al método 'editarReceta' del DAO para actualizar la tabla receta en la base de datos
        $editedRecetaDTO = $IRecetaDAO->editarReceta($recetaDTO);

        //obtengo el id de la receta modificada
        $editedId = $editedRecetaDTO->getID();
       //-----------------------------------------------------------------------------------
        //Guardamos los ingredientes modificados
        $ingredienteRecetaService = ingredienteRecetaAppService::GetSingleton(); 
        //obtengo la lista de los ingredientes asociados a dicha receta
        $ingredientesExistentes = $ingredienteRecetaService->buscarIngredienteReceta($editedId);

        // Eliminar todos los ingredientes existentes
        foreach ($ingredientesExistentes as $ingrediente) {
            $ingredienteRecetaDTO = new ingredienteRecetaDTO($editedId, $ingrediente['Ingrediente'], 0, $ingrediente['Magnitud']);
            $ingredienteRecetaService->borrarIngredienteReceta($ingredienteRecetaDTO);
        }

        // Guardamos los nuevos ingredientes
        foreach ($ingredientes as $ingredienteId => $ingredienteData) {
            $ingredienteId = intval($ingredienteId);
            $cantidad = floatval($ingredienteData['cantidad'] ?? 0);
            $magnitud = filter_var($ingredienteData['magnitud'] ?? 0, FILTER_VALIDATE_INT);
            
            // Si el ingrediente es válido, lo guarda
            if ($ingredienteId > 0 && $cantidad > 0) {
                $ingredienteRecetaDTO = new ingredienteRecetaDTO($editedId, $ingredienteId, $cantidad, $magnitud);
                $ingredienteRecetaService->crearIngredienteReceta($ingredienteRecetaDTO);
            }
        }
            
        //ETIQUETAS
        $etiquetaRecetaService = etiquetaRecetaAppService::GetSingleton();

        //obtengo la lista de las etiquetas asociadas a dicha receta
        $etiquetasExistentes = $etiquetaRecetaService->buscarEtiquetaReceta($editedId);

        // Eliminar todas las etiquetas existentes
        foreach ($etiquetasExistentes as $etiqueta) {
            $etiquetaRecetaDTO = new etiquetaRecetaDTO($editedId, $etiqueta);
            $etiquetaRecetaService->borrarEtiquetaReceta($etiquetaRecetaDTO);
        }
        // Limitar las nuevas etiquetas a un máximo de 3 únicas
        $nuevasEtiquetas = array_slice(array_unique($etiquetas), 0, 3);

        foreach ($etiquetas as $nombreEtiqueta) {
            $nombreEtiqueta = filter_var($nombreEtiqueta, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // Si la etiqueta es válida, la guarda
            if (!empty($nombreEtiqueta)) {
                $etiquetaRecetaDTO = new etiquetaRecetaDTO($editedId, $nombreEtiqueta);
                $etiquetaRecetaService->crearEtiquetaReceta($etiquetaRecetaDTO);
            }
        }

       
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

        //obtengo el ID de la receta a borrar
        $deletedId = $deletedRecetaDTO->getID();

        //Servicio para la gestión de ingredientes de la receta
        $ingredienteRecetaService = ingredienteRecetaAppService::GetSingleton();

        $ingredienteRecetaService->borrarIngredienteReceta($deletedId);



        // Devuelve el objeto DTO borrado
        return $deletedRecetaDTO;
    }

    public function mostarRecetasPorAutor($userDTO){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->mostarRecetasPorAutor($userDTO);
        
    }


    public function mostrarRecetas($criterio){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->mostrarRecetas($criterio);
    }

    public function buscarRecetaPorId($id){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->buscarReceta($id);
    }

    public function busquedaDinamica($buscarPlato, $ordenar, $precioMin, $precioMax, $valoracion, $etiquetas){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->busquedaDinamica($buscarPlato, $ordenar, $precioMin, $precioMax, $valoracion, $etiquetas);
    }
}

?>
