<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};
use es\ucm\fdi\aw\entidades\usuario\{userAppService};
use es\ucm\fdi\aw\entidades\ingredienteReceta\{ingredienteRecetaAppService};
use es\ucm\fdi\aw\entidades\etiquetaReceta\{etiquetaRecetaAppService};

class mostrarRecetaHelper
{
    private $recetaDTO;
    private $ingredientes;
    private $autor;
    private $etiquetas;

    public function __construct($recetaId) 
    {
        $recetaService = recetaAppService::GetSingleton();
        $this->recetaDTO = $recetaService->buscarRecetaPorId(new RecetaDTO($recetaId, null, null, null, null, null, null, null, null, null));
        
        $usuarioService = userAppService::GetSingleton();
        $this->autor = $usuarioService->buscarUsuarioPorID($this->recetaDTO->getAutor());

        $ingredienteRecetaService = ingredienteRecetaAppService::GetSingleton();
        $this->ingredientes = $ingredienteRecetaService->buscarIngredienteReceta($this->recetaDTO, 'nombres');
    
        $etiquetaRecetaService = etiquetaRecetaAppService::GetSingleton();
        $this->etiquetas = $etiquetaRecetaService->buscarEtiquetaReceta($this->recetaDTO);
    }

    public function print()
    {
        return $this->generarReceta();
    }

    public function generarReceta()
    {
        if (!$this->recetaDTO) {
            return "<p>Error: La receta no existe.</p>";
        }
    
        $nombre = htmlspecialchars($this->recetaDTO->getNombre());
        $autor = htmlspecialchars($this->autor->getNombre());
        $descripcion = nl2br(htmlspecialchars($this->recetaDTO->getDescripcion()));
        $tiempo = htmlspecialchars($this->recetaDTO->getTiempo()) . " minutos";
        $precio = htmlspecialchars($this->recetaDTO->getPrecio()) . "€";
        $valoracion = htmlspecialchars($this->recetaDTO->getValoracion()) ?: "Sin valoración";
        $rutaImagen = "img/receta/" . htmlspecialchars($this->recetaDTO->getRuta());
    
        // Formatear fecha (solo día/mes/año)
        $fechaCreacion = date("d/m/Y", strtotime($this->recetaDTO->getFechaCreacion()));
    
        // Convertir los pasos de JSON a array
        $pasosArray = json_decode($this->recetaDTO->getPasos(), true);
        $listaPasos = "<div class='receta-pasos'>";
        foreach ($pasosArray as $indice => $paso) {
            $numPaso = $indice + 1;
            $listaPasos .= "<p><strong>Paso $numPaso:</strong> " . htmlspecialchars($paso) . "</p>";
        }
        $listaPasos .= "</div>";

        $etiquetas = $this->generarEtiquetas();
        $ingredientes = $this->generarIngredientes();
        return <<<HTML
            <section>
                <div class="receta-detalle">
                    <h1>$nombre</h1>
                    <img src="$rutaImagen" alt="$nombre" class="receta-imagen-detalle">
                    <p><strong>Autor:</strong> $autor</p>
                    <p><strong>Descripción:</strong> $descripcion</p>
                    <p><strong>Tiempo de preparación:</strong> $tiempo</p>
                    <p><strong>Precio:</strong> $precio</p>
                    <p><strong>Valoración:</strong> $valoracion</p>
                    <p><strong>Fecha de creación:</strong> $fechaCreacion</p>
                    $etiquetas
                </div>
                <div>
                    <h2>Pasos de la receta</h2>
                    $listaPasos
                    $ingredientes
                </div>
            </section>
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