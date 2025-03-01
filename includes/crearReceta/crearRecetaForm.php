<?php

include __DIR__ . '/../comun/formularioBase.php';
include __DIR__ . '/../receta/recetaAppService.php';

class crearRecetaForm extends formularioBase
{
    public function __construct() 
    {
        parent::__construct('crearRecetaForm');
    }
    
    protected function CreateFields($datos)
    {
        $titulo = $datos['titulo'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $precio = $datos['precio'] ?? '';
        
        $html = <<<EOF
        <fieldset>
            <legend>Crear Receta</legend>
            <p><label>Título:</label> <input type="text" name="titulo" value="$titulo" required/></p>
            <p><label>Descripción:</label> <textarea name="descripcion" required>$descripcion</textarea></p>
            <p><label>Precio:</label> <input type="number" step="0.01" name="precio" value="$precio" required/></p>
            <button type="submit" name="crear">Crear Receta</button>
        </fieldset>
        EOF;
        return $html;
    }
    
    protected function Process($datos)
    {
        $result = array();

        $titulo = trim($datos['titulo'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');
        $precio = trim($datos['precio'] ?? '');
        
        if (empty($titulo)) {
            $result[] = "El título no puede estar vacío.";
        }
        if (empty($descripcion)) {
            $result[] = "La descripción no puede estar vacía.";
        }
        if (!is_numeric($precio) || $precio < 0) {
            $result[] = "El precio debe ser un número positivo.";
        }
        
        if (count($result) === 0) {
            //$recetaDTO = new recetaDTO(0, $titulo, $descripcion, $precio);
            $recetaDTO = null;
            $recetaAppService = recetaAppService::GetSingleton();
            
            if (!$recetaAppService->create($recetaDTO)) {
                $result[] = "Error al crear la receta.";
            } else {
                $result = 'index.php';
            }
        }
        return $result;
    }
}