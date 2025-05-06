<?php

namespace es\ucm\fdi\aw\entidades\receta;

use es\ucm\fdi\aw\entidades\ingredienteReceta\{ingredienteRecetaFactory, ingredienteRecetaDTO};
use es\ucm\fdi\aw\entidades\etiquetaReceta\{etiquetaRecetaFactory, etiquetaRecetaDTO};

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
    public function crearReceta($recetaDTO, $ingredienteArray, $etiquetaArray)
    {
        // Receta
        $IRecetaDAO = recetaFactory::CreateReceta();
        $createdRecetaDTO = $IRecetaDAO->crearReceta($recetaDTO);
        $idReceta = $createdRecetaDTO->getId();

        //Ingredientes
        $IIngredienteRecetaDAO = ingredienteRecetaFactory::CreateIngredienteReceta();

        foreach ($ingredienteArray as $ingredienteData) {
            $ingredienteId = intval($ingredienteData['id']);
            $cantidad = floatval($ingredienteData['cantidad']);
            $magnitud = filter_var($ingredienteData['magnitud']);
        
            // Si el ingrediente es válido, lo guarda
            if ($ingredienteId > 0 && $cantidad > 0) {
                $ingredienteRecetaDTO = new ingredienteRecetaDTO($idReceta, $ingredienteId, $cantidad, $magnitud);
                $IIngredienteRecetaDAO->crearIngredienteReceta($ingredienteRecetaDTO);
            }
        }

        //Etiquetas
        $IEtiquetaRecetaDAO = etiquetaRecetaFactory::createEtiquetaReceta();

        $etiquetas = array_slice(array_unique($etiquetaArray), 0, 3); // Limita a 3 etiquetas únicas
        foreach ($etiquetas as $etiqueta) {
            $etiqueta = filter_var($etiqueta, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Si la etiqueta es válida, la guarda
            if (!empty($etiqueta)) {
                $etiquetaRecetaDTO = new etiquetaRecetaDTO($idReceta, $etiqueta);
                $IEtiquetaRecetaDAO->crearEtiquetaReceta($etiquetaRecetaDTO);
            }
        }
    }

    // Método para editar una receta
    public function editarReceta($recetaDTO, $ingredienteArray, $etiquetaArray)
    {
        // Receta
        $IRecetaDAO = recetaFactory::CreateReceta();
        $editedRecetaDTO = $IRecetaDAO->editarReceta($recetaDTO); 
        $idReceta = $editedRecetaDTO->getId();

        //Ingrediente
        $IIngredienteRecetaDAO = ingredienteRecetaFactory::CreateIngredienteReceta();
        $IIngredienteRecetaDAO->borrarIngredienteReceta($recetaDTO);

        foreach ($ingredienteArray as $ingredienteData) {
            $ingredienteId = intval($ingredienteData['id']);
            $cantidad = floatval($ingredienteData['cantidad']);
            $magnitud = filter_var($ingredienteData['magnitud']);
        
            // Si el ingrediente es válido, lo guarda
            if ($ingredienteId > 0 && $cantidad > 0) {
                $ingredienteRecetaDTO = new ingredienteRecetaDTO($idReceta, $ingredienteId, $cantidad, $magnitud);
                $IIngredienteRecetaDAO->crearIngredienteReceta($ingredienteRecetaDTO);
            }
        }
        
        //Etiqueta
        $IEtiquetaRecetaDAO = etiquetaRecetaFactory::createEtiquetaReceta();
        $IEtiquetaRecetaDAO->borrarEtiquetaReceta($recetaDTO);

        $etiquetas = array_slice(array_unique($etiquetaArray), 0, 3); // Limita a 3 etiquetas únicas
        foreach ($etiquetas as $etiqueta) {
            $etiqueta = filter_var($etiqueta, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Si la etiqueta es válida, la guarda
            if (!empty($etiqueta)) {
                $etiquetaRecetaDTO = new etiquetaRecetaDTO($idReceta, $etiqueta);
                $IEtiquetaRecetaDAO->crearEtiquetaReceta($etiquetaRecetaDTO);
            }
        }
    }

    // Método para borrar una receta
    public function borrarReceta($recetaDTO)
    {
        //Ingrediente
        $IIngredienteRecetaDAO = ingredienteRecetaFactory::CreateIngredienteReceta();
        $IIngredienteRecetaDAO->borrarIngredienteReceta($recetaDTO);
    
        //Etiqueta
        $IEtiquetaRecetaDAO = etiquetaRecetaFactory::createEtiquetaReceta();
        $IEtiquetaRecetaDAO->borrarEtiquetaReceta($recetaDTO);
        
        // Receta
        $IRecetaDAO = recetaFactory::CreateReceta();
        $IRecetaDAO->borrarReceta($recetaDTO); 
    }

    public function mostrarRecetasPorAutor($userDTO){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->mostrarRecetasPorAutor($userDTO);
        
    }

    public function mostrarRecetasPorComprador($userDTO){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->mostrarRecetasPorComprador($userDTO);
        
    }


    public function mostrarRecetas($criterio){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->mostrarRecetas($criterio);
    }

    public function buscarRecetaPorId($recetaDTO){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->buscarReceta($recetaDTO);
    }

    public function buscarRecetasConEtiquetas($etiquetas, $recetaDTO) {
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->buscarRecetasConEtiquetas($etiquetas, $recetaDTO);
    }

    public function esAutor($recetaDTO){
        $IRecetaDAO = recetaFactory::CreateReceta();

        return $IRecetaDAO->esAutor($recetaDTO);
    }
}

?>
