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
        //echo($editedId);
       //-----------------------------------------------------------------------------------
        //Guardamos los ingredientes modificados
        $ingredienteRecetaService = ingredienteRecetaAppService::GetSingleton(); 
        //obtengo la lista de los ingredientes asociados a dicha receta. Comprobado que esta bien
        $ingredientesExistentes = $ingredienteRecetaService->buscarIngredienteReceta($editedId, 'ids');

        //BORRADOR------------------------------------------------------------------------
        $ingredienteRecetaService->borrarIngredienteReceta($editedId);
        //--------------------------------------------------------------------------------
        // Eliminar todos los ingredientes existentes
        /*
        foreach ($ingredientesExistentes as $ingredienteId => $ingredienteData) {
            $ingredienteId = intval($ingredienteData['ID']);
            $cantidad = floatval($ingredienteData['Cantidad'] ?? 0);
            $magnitud = filter_var($ingredienteData['Magnitud'] ?? 0, FILTER_VALIDATE_INT);
           
            $ingredienteRecetaDTO = new ingredienteRecetaDTO($editedId, $ingredienteId, $cantidad, $magnitud);
            $ingredienteRecetaService->borrarIngredienteReceta($ingredienteRecetaDTO);
        }
        */

        // Guardamos los nuevos ingredientes
        foreach ($ingredientes as $ingredienteId => $ingredienteData) {
            $ingredienteId = intval($ingredienteId);
            $cantidad = floatval($ingredienteData['cantidad'] ?? 0);
            $magnitud = filter_var($ingredienteData['magnitud'] ?? 0, FILTER_VALIDATE_INT);
            
            // Si el ingrediente es válido, lo guarda
            if ($ingredienteId > 0 && $cantidad > 0) {
                // Verifica si el ingrediente ya existe
                $ingredienteExistente = false;
                foreach ($ingredientesExistentes as $ingredienteExistenteData) {
                    if ($ingredienteExistenteData->getIngrediente() == $ingredienteId) {
                        $ingredienteExistente = true;
                        break;
                    }
                }
                 // Solo agrega si no existe
                if (!$ingredienteExistente) {
                    $ingredienteRecetaDTO = new ingredienteRecetaDTO($editedId, $ingredienteId, $cantidad, $magnitud);
                    $ingredienteRecetaService->crearIngredienteReceta($ingredienteRecetaDTO);
                }
            }
        }
            
        //ETIQUETAS------------------------------------------------------------------------
        $etiquetaRecetaService = etiquetaRecetaAppService::GetSingleton();
        //obtengo la lista de las etiquetas asociadas a dicha receta. Verificado ESTA BIEN
        $etiquetasExistentes = $etiquetaRecetaService->buscarEtiquetaReceta($editedId);
        //BORRADOR------------------------------------------------------------------------
        $etiquetaRecetaService->borrarEtiquetaReceta($editedId);
        //--------------------------------------------------------------------------------
        // Eliminar todas las etiquetas existentes
        /*
        foreach ($etiquetasExistentes as $etiqueta) {
            $etiquetaRecetaDTO = new etiquetaRecetaDTO($editedId, $etiqueta);
            //var_dump($etiqueta);
            //die();
            $etiquetaRecetaService->borrarEtiquetaReceta($etiquetaRecetaDTO);
        }
        */
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
    public function borrarReceta($recetaId)
    {
        // Crea el objeto IRecetaDAO utilizando la fábrica (factory)
        $IRecetaDAO = recetaFactory::CreateReceta();

        // Llama al método 'borrarReceta' del DAO para eliminar la receta de la base de datos
        $deletedRecetaDTO = $IRecetaDAO->borrarReceta($recetaId); 

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

}

?>
