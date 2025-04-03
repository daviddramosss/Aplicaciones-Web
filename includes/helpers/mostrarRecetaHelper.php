<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\{recetaAppService};
use es\ucm\fdi\aw\entidades\usuario\{userAppService};
use es\ucm\fdi\aw\entidades\ingredienteReceta\{ingredienteRecetaAppService};
use es\ucm\fdi\aw\entidades\etiquetaReceta\{etiquetaRecetaAppService};

class mostrarRecetaHelper
{
    private $receta;
    private $ingredientes;
    private $autor;
    private $etiquetas;

    public function __construct($recetaId) 
    {
        $recetaService = recetaAppService::GetSingleton();
        $this->receta = $recetaService->buscarRecetaPorId($recetaId);
        
        $usuarioService = userAppService::GetSingleton();
        $this->autor = $usuarioService->buscarUsuarioPorID($this->receta->getAutor());

        $ingredienteRecetaService = ingredienteRecetaAppService::GetSingleton();
        $this->ingredientes = $ingredienteRecetaService->buscarIngredienteReceta($recetaId, 'nombres');
    
        $etiquetaRecetaService = etiquetaRecetaAppService::GetSingleton();
        $this->etiquetas = $etiquetaRecetaService->buscarEtiquetaReceta($recetaId);
    }

    public function print()
    {
        return $this->generarReceta() . $this->generarEtiquetas() . $this->generarIngredientes() ;
    }

    public function generarReceta()
    {
        if (!$this->receta) {
            return "<p>Error: La receta no existe.</p>";
        }
    
        $nombre = htmlspecialchars($this->receta->getNombre());
        $autor = htmlspecialchars($this->autor->getNombre());
        $descripcion = nl2br(htmlspecialchars($this->receta->getDescripcion()));
        $tiempo = htmlspecialchars($this->receta->getTiempo()) . " minutos";
        $precio = htmlspecialchars($this->receta->getPrecio()) . "€";
        $valoracion = htmlspecialchars($this->receta->getValoracion()) ?: "Sin valoración";
        $rutaImagen = "img/receta/" . htmlspecialchars($this->receta->getRuta());
    
        // Formatear fecha (solo día/mes/año)
        $fechaCreacion = date("d/m/Y", strtotime($this->receta->getFechaCreacion()));
    
        // Convertir los pasos de JSON a array
        $pasosArray = json_decode($this->receta->getPasos(), true);
        $listaPasos = "<div class='receta-pasos'>";
        foreach ($pasosArray as $indice => $paso) {
            $numPaso = $indice + 1;
            $listaPasos .= "<p><strong>Paso $numPaso:</strong> " . htmlspecialchars($paso) . "</p>";
        }
        $listaPasos .= "</div>";
    
        return <<<HTML
            <div class="receta-detalle">
                <h1>$nombre</h1>
                <img src="$rutaImagen" alt="$nombre" class="receta-imagen-detalle">
                <p><strong>Autor:</strong> $autor</p>
                <p><strong>Descripción:</strong> $descripcion</p>
                <p><strong>Tiempo de preparación:</strong> $tiempo</p>
                <p><strong>Precio:</strong> $precio</p>
                <p><strong>Valoración:</strong> $valoracion</p>
                <p><strong>Fecha de creación:</strong> $fechaCreacion</p>
                <h2>Pasos de la receta</h2>
                $listaPasos
            </div>
        HTML;
    }
    
    public function generarIngredientes() {   
        $html = '<h2>Lista de ingredientes</h2>';  
        $html .= '<div class="receta-ingrediente-cards">';
        
        foreach ($this->ingredientes as $ingrediente) {
            $html .= <<<HTML
                <div class="receta-ingrediente-card">                    
                    <p>
                        {$ingrediente->getIngrediente()}:
                        {$ingrediente->getCantidad()} 
                        {$ingrediente->getMagnitud()}
                    </p>
                </div>
            HTML;
        }    
    
        $html .= '</div>';
        
        return $html;
    }

    public function generarEtiquetas() {   
        $html = '<h2>Etiquetas</h2>';    
    
        $html .= '<div class="receta-etiquetas">';
        foreach ($this->etiquetas as $etiqueta) {
            $html .= <<<HTML
                <span class="tag">{$etiqueta->getNombre()}</span>
            HTML;
        }    

        $html .= '</div>';
    
        return $html;
    }
    



}