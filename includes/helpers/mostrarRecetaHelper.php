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
    private $esComprador = false;
    private $logueado = false;
    private $esAutor = false;

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
        
        $this->similares = $recetaService->buscarRecetasConEtiquetas($this->etiquetas, new recetaDTO($recetaId, null, null, null, null, null, null, null, null));
        
        $recetaCompradaService = recetaCompradaAppService::GetSingleton();
        
        if(isset($_SESSION["login"])){
            $this->esAutor = $recetaService->esAutor(new recetaDTO($recetaId, null, $_SESSION["id"], null, null, null, null, null, null));
            if(!$this->esAutor){
                $this->esComprador = $recetaCompradaService->esComprador(new recetaCompradaDTO($_SESSION["id"], $recetaId));
            }
            $this->logueado = true;
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
        // Mostrar los pasos y los ingredientes solo si es comprador
        if ($this->esComprador || $this->esAutor) {
            $pasosArray = json_decode($this->recetaDTO->getPasos(), true);
            $listaPasos = "<h2>Pasos de la receta</h2>";
            $listaPasos .= "<div class='receta-pasos'>";

            foreach ($pasosArray as $indice => $paso) {
                $numPaso = $indice + 1;
                $listaPasos .= "<p><strong>Paso $numPaso:</strong> " . htmlspecialchars($paso) . "</p>";
            }
            $listaPasos .= "</div>";
        } else {

            $listaPasos = "
            <div>
                <p class='candado'>🔒</p>
            ";
            if(!$this->logueado){
                $listaPasos.= "
                <p> ¡No estas logueado! Inicia sesión primero</p>
                ";
            } 
            else{
                $listaPasos.= "
                    <p> ¡No tienes comprada esta receta!
                    <p>Debes comprar la receta para ver los pasos de preparación.</p>
                ";
            }
            $listaPasos.= "</div>";
        }


        $etiquetas = $this->generarEtiquetas();
        $ingredientes = ""; //Si no es comprador, los ingredientes están vacíos
        if ($this->esComprador || $this->esAutor) {
            $ingredientes = $this->generarIngredientes();
        }
        // Lógica de usuarios
        // Si esta logueado y es comprador no muestra ningun boton
        // Si esta logueado y NO es comprador, muestra el boton de añadir al carrito con su texto
        // Si NO esta logueado, muestra el boton de iniciar sesion con su texto
        $botonCarrito = "";
        if($this->logueado){
            if(!$this->esComprador && !$this->esAutor){
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

        $recetas_aux = "";
        if (empty($this->similares)) {
            $recetas_aux ="<p>No existen recetas que cumplan esos criterios.</p>";
        }
        else{

            $recetas_aux = '<div class="recetas-container">';
            
                foreach ($this->similares as $receta) {
                    $recetas_aux .= <<<HTML
                        <div class="receta-card">
                            <a href="mostrarReceta.php?id={$receta->getId()}">
                                <img src="img/receta/{$receta->getRuta()}" alt="{$receta->getNombre()}" class="receta-imagen">
                            </a>
                            <p class="receta-titulo">{$receta->getNombre()}</p>
                        </div>
                    HTML;
                }
            
            $recetas_aux .= '</div>';
        }
        
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