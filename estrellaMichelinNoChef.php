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
        
        <!-- Campo para el DNI -->
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required>
        <br><br>
        
        <!-- Campo para la cuenta bancaria -->
        <label for="cuentaBancaria">Cuenta bancaria:</label>
        <input type="text" id="cuentaBancaria" name="cuentaBancaria" required>
        <br><br>
        
        

    </form>

EOS;

// Se incluye la plantilla general de la página, que probablemente contiene la estructura base del sitio web
require("includes/comun/plantilla.php");

?>
