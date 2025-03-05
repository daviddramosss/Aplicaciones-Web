<?php
$tituloPagina = 'Estrella Michelin';

$contenidoPrincipal = <<<EOS

<link rel="stylesheet" href="CSS/terminos.css">
    <h1 class="titulo-centrado">¡Conviertete en Estrella Michelin!</h1>
    
    
    <p>¡Conviértete en una Estrella Michelin en Market Chef y lleva tus recetas al siguiente nivel! Al darte de alta, podrás vender tus creaciones culinarias a una audiencia apasionada por la buena comida. No importa si eres un chef experimentado o un amante de la cocina, esta es tu oportunidad de brillar. Comparte tus platos únicos y empieza a generar ingresos con tu talento. ¡Únete hoy y haz que tu pasión por la cocina sea reconocida y valorada por todos!</p>

    <h2>Formulario de Acreditación</h2>
    <form action="procesar_formulario.php" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>
    <br><br>
    
    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos" required>
    <br><br>
    
    <label for="sexo">Sexo:</label>
    <select id="sexo" name="sexo" required>
        <option value="masculino">Masculino</option>
        <option value="femenino">Femenino</option>
        <option value="otro">Otro</option>
    </select>
    <br><br>
    
    <label for="motivo">¿Por qué te gustaría entrar en MarketChef?</label>
    <br>
    <textarea id="motivo" name="motivo" rows="4" cols="50" required></textarea>
    <br><br>
    
    <button type="submit">Enviar</button>
</form>
EOS;

require("includes/comun/plantilla.php");
?>