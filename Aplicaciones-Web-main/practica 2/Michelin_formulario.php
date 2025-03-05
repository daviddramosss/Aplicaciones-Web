<!DOCTYPE html>
<html lang="es"> 
<!-- Página de contacto -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Conviertete en Estrella Michelin!</title>
    <style>
        /* Estilo para el título principal */
        .titulo-principal {
            font-size: 4em; /* Tamaño grande */
            color: #2c3e50; /* Color oscuro */
            text-align: center; /* Centrado horizontal */
            text-decoration: underline; /* Subrayado */
            margin-top: 20px; /* Espaciado superior */
        }
    </style>
</head>
<body>
    <!-- Título en H1 -->
    <h1 class="titulo-principal">¡Conviertete en Estrella Michelin!</h1>
    
    <p class="parrafo-introduccion">Regístrate como chef Estrella Michelin y 
    lleva tu cocina al siguiente nivel. Aunque no seas un chef acreditado,
    nuestro equipo evaluará tu talento y te brindará la oportunidad de 
    mostrar tus recetas al mundo. Forma parte de una comunidad exclusiva 
    de expertos y comparte tu pasión con un público global. ¡Es tu momento de 
    destacar y transformar tu talento en una carrera de éxito!</p>

    <!-- Formulario de contacto -->
    <h2 class="subtitulo-formulario">Formulario de Acreditación</h2>
    
    <!-- Acción al darle a Enviar en el Formulario: Abre la aplicación de correo por defecto del usuario y permite 
          enviar el contenido del formulario directamente a nuestro correo -->
    <form action="mailto:correo@ejemplo.com" method="post" enctype="text/plain">

        <!-- Label del campo Nombre y el cuadro para introducirlo -->
        <label class="etiqueta" for="nombre">Nombre:</label>  
        <input class="campo-texto" type="text" id="nombre" name="nombre" required>
        
        <!-- Label del campo Apellidos y el cuadro para introducirlo -->
        <label class="etiqueta" for="apellidos">Apellidos:</label>
        <input class="campo-texto" type="text" id="apellidos" name="apellidos" required>
        
        <!-- Label del campo Sexo y los Radio Buttons correspondientes para seleccionarlo  -->
        <p class="label-sexo">Sexo:</p>
        <div class="radio-group">
            <label><input type="radio" id="Masculino" name="Sexo" value="Masculino" required> Masculino</label>
            <label><input type="radio" id="Femenino" name="Sexo" value="Femenino" required> Femenino</label>
        </div>
        
        <!-- Casilla obligatoria a marcar por el usuario indicando que acepta nuestros términos y condiciones -->
        <div class="checkbox-group">
            <label><input type="checkbox" id="terminos" name="terminos" required> He leído y acepto los términos y condiciones</label>
        </div>
        
        <!-- Label del campo mensaje y el cuadro para introducirlo -->
        <label class="etiqueta" for="mensaje">Por qué te gustaría entrar en MarketChef:</label>
        <textarea class="campo-texto" id="mensaje" name="mensaje" rows="4" required></textarea>
        
        <!-- Nombre para el botón de enviar, del tipo submit, que realiza la acción del formulario -->
        <button class="boton-enviar" type="submit">Enviar</button>
    </form>
</body>
</html>
