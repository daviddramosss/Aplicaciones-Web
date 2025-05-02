<?php

namespace es\ucm\fdi\aw\helpers;

use es\ucm\fdi\aw\entidades\receta\{recetaAppService, recetaDTO};
use es\ucm\fdi\aw\entidades\usuario\{userAppService, userDTO};
use es\ucm\fdi\aw\entidades\ingredienteReceta\{ingredienteRecetaAppService};
use es\ucm\fdi\aw\entidades\etiquetaReceta\{etiquetaRecetaAppService};
use es\ucm\fdi\aw\entidades\recetaComprada\{recetaCompradaAppService, recetaCompradaDTO};

class mostrarRecetaHelper
{
    private $recetaDTO;
    private $ingredientes;
    private $autor;
    private $etiquetas;
    private $similares;
    private $esComprador;
    private $logueado;

    public function __construct() 
    {
    }

    public function init($recetaId)
    {
        $recetaService = recetaAppService::GetSingleton();
        $this->recetaDTO = $recetaService->buscarRecetaPorId(new recetaDTO($recetaId, null, null, null, null, null, null, null, null));
        
        $usuarioService = userAppService::GetSingleton();
        $this->autor = $usuarioService->buscarUsuarioPorID(new userDTO($this->recetaDTO->getAutor(), null, null, null, null, null, null));

        $ingredienteRecetaService = ingredienteRecetaAppService::GetSingleton();
        $this->ingredientes = $ingredienteRecetaService->buscarIngredienteReceta(new recetaDTO($recetaId, null, null, null, null, null, null, null, null), 'nombres');
    
        $etiquetaRecetaService = etiquetaRecetaAppService::GetSingleton();
        $this->etiquetas = $etiquetaRecetaService->buscarEtiquetaReceta(new recetaDTO($recetaId, null, null, null, null, null, null, null, null));

        $this->similares = $recetaService->buscarRecetasConEtiquetas($this->etiquetas, $recetaId);
        
        $recetaCompradaService = recetaCompradaAppService::GetSingleton();

        if(isset($_SESSION["login"])){
            $this->esComprador = $recetaCompradaService->esComprador(new recetaCompradaDTO($_SESSION["id"], $recetaId));
            $this->logueado = true;
        }
        else{
            $this->logueado = false;
            $this->esComprador = false;
        }
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
        $rutaImagen = "img/receta/" . htmlspecialchars($this->recetaDTO->getRuta());
    
        // Formatear fecha (solo día/mes/año)
        $fechaCreacion = date("d/m/Y", strtotime($this->recetaDTO->getFechaCreacion()));
    
        // Convertir los pasos de JSON a array v1
        /*
        $pasosArray = json_decode($this->recetaDTO->getPasos(), true);
        $listaPasos = "<div class='receta-pasos'>";
        foreach ($pasosArray as $indice => $paso) {
            $numPaso = $indice + 1;
            $listaPasos .= "<p><strong>Paso $numPaso:</strong> " . htmlspecialchars($paso) . "</p>";
        }
        $listaPasos .= "</div>";*/

        // Mostrar los pasos solo si es comprador
        if ($this->esComprador) {
            $pasosArray = json_decode($this->recetaDTO->getPasos(), true);
            $listaPasos = "<h2>Pasos de la receta</h2>";
            $listaPasos .= "<div class='receta-pasos'>";

            foreach ($pasosArray as $indice => $paso) {
                $numPaso = $indice + 1;
                $listaPasos .= "<p><strong>Paso $numPaso:</strong> " . htmlspecialchars($paso) . "</p>";
            }
            $listaPasos .= "</div>";
        } else {
            $listaPasos = "<div class='bloqueado'><p>Debes comprar la receta para ver los pasos de preparación.</p></div>";
        }


        $etiquetas = $this->generarEtiquetas();
        $ingredientes = "";
        if ($this->esComprador) {
            $ingredientes = $this->generarIngredientes();
        }
        $botonCarrito = "";
        if($this->logueado){
            if(!$this->esComprador){
                $botonCarrito = "
                <form action='anadirCarrito.php' method='post'>
                    <input type='hidden' name='recetaId' value='{$this->recetaDTO->getId()}'>
                    <button type='submit' class='send-button'>AÑADIR AL CARRITO</button>
                </form>
                ";
            }
        }
        else{
            $botonCarrito = " 
                <button type='button' class='send-button' onclick='location.href=`login.php`'> INICIAR SESIÓN</button>
            ";
        }
        $recetas_aux = $this->similares;
        return <<<HTML
            <section>
                <div class="receta-detalle">
                    <h1>$nombre</h1>
                    <img src="$rutaImagen" alt="$nombre" class="receta-imagen-detalle">
                    <p><strong>Autor:</strong> $autor</p>
                    <p><strong>Descripción:</strong> $descripcion</p>
                    <p><strong>Tiempo de preparación:</strong> $tiempo</p>
                    <p><strong>Precio:</strong> $precio</p>
                    <p><strong>Fecha de creación:</strong> $fechaCreacion</p>
                    $etiquetas
                </div>
                <div class="receta-detalle">
                    $listaPasos
                    $ingredientes
                    $botonCarrito
                </div>
            </section>
            <section> 
            </section>
            <br>
            <h2> Recetas similares </h2>
            $recetas_aux




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