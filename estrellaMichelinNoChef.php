<?php

// Define el título de la página
$tituloPagina = 'Estrella Michelin';

// Se utiliza la sintaxis de heredoc (<<<EOS) para almacenar el contenido HTML principal en una variable PHP
$contenidoPrincipal = <<<EOS

    <!-- Enlace a la hoja de estilos específica para esta página -->
    <link rel="stylesheet" href="CSS/terminos.css">

    <!-- Título principal de la página -->
    <h1 class="titulo-centrado">¡Conviértete en Estrella Michelin!</h1>
    
    <!-- Descripción de la funcionalidad de inscripción -->
    <p>¡Conviértete en una Estrella Michelin en Market Chef y lleva tus recetas al siguiente nivel! 
       Al darte de alta, podrás vender tus creaciones culinarias a una audiencia apasionada por la buena comida. 
       No importa si eres un chef experimentado o un amante de la cocina, esta es tu oportunidad de brillar. 
       Comparte tus platos únicos y empieza a generar ingresos con tu talento. 
       ¡Únete hoy y haz que tu pasión por la cocina sea reconocida y valorada por todos!</p>

    <!-- Formulario de acreditación para unirse como chef en Market Chef -->
    <h2>Formulario de Acreditación</h2>
    <form action="procesar_formulario.php" method="post">
        
        <!-- Campo para el nombre -->
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>
        
        <!-- Campo para los apellidos -->
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>
        <br><br>
        
        <!-- Selector de sexo -->
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
            <option value="otro">Otro</option>
        </select>
        <br><br>
        
        <!-- Área de texto para el motivo de inscripción -->
        <label for="motivo">¿Por qué te gustaría entrar en Market Chef?</label>
        <br>
        <textarea id="motivo" name="motivo" rows="4" cols="50" required></textarea>
        <br><br>
        
        <!-- Botón para enviar el formulario -->
        <button type="submit">Enviar</button>

    </form>

EOS;

// Se incluye la plantilla general de la página, que probablemente contiene la estructura base del sitio web
require("includes/comun/plantilla.php");

?>
