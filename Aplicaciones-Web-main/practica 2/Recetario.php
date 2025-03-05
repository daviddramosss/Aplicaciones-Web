<?php
$tituloPagina = "Mi recetario";
$contenidoPrincipal = <<<EOS
   <h1>¡MI RECETARIO!</h1>
EOS;

$contenido1 = "<p>Este es el primer contenido.</p>";
$contenido2 = "<p>Este es el segundo contenido.</p>";
$contenido3 = "<p>Este es el tercer contenido.</p>";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contenido con botón</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Estilo para el título "MI RECETARIO" */
        .titulo-recetario {
            font-size: 4em; /* Tamaño grande */
            color: #333; /* Color del texto */
            text-align: center; /* Centrado horizontal */
            text-decoration: underline; /* Subrayado */
            margin-top: 20vh; /* Centrado vertical */
        }

        /* Estilo para el contenido dinámico */
        #contenido {
            font-size: 1.5em; /* Menor tamaño que el título */
            text-align: center; /* Alineación centrada */
            padding: 10px;
            margin-top: 20px;
        }

        /* Estilo de las flechas (más grandes y más cerca de los márgenes) */
        .boton-flecha {
            cursor: pointer;
            width: 60px; /* Mayor tamaño */
            height: 60px; /* Mayor tamaño */
            margin: 0 10px; /* Menor distancia a los márgenes */
        }

        /* Contenedor de las flechas y contenido */
        .contenedor-flechas {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        /* Espaciado entre las flechas y el contenido */
        #cambiarContenido,
        #contenidoAnterior {
            margin: 0 10px; /* Reducción de margen para acercar las flechas */
        }

        /* Otros estilos */
        .subtitulo-recetas,
        .subtitulo-wishlist {
            font-size: 2.5em;
            color: #666;
        }

        .contenido {
            font-size: 1.2em;
            padding: 15px;
            margin-top: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .container {
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <!-- Título en H1 -->
    <h1 class="titulo-recetario">MI RECETARIO</h1>
   
    <h1 class="subtitulo-recetas">RECETAS COMPRADAS</h1>

    <!-- Contenedor de las flechas y contenido -->
    <div class="contenedor-flechas">
        <!-- Imagen para cambiar contenido hacia atrás -->
        <img src="flecha_izquierda.jpg" alt="Contenido anterior" id="contenidoAnterior" class="boton-flecha">

        <!-- Contenedor principal de contenido dinámico -->
        <div id="contenido" class="contenido">
            <p>-Todavía no se han comprado recetas-.</p>
        </div>

        <!-- Imagen para cambiar contenido hacia adelante -->
        <img src="flecha_derecha.jpg" alt="Cambiar contenido" id="cambiarContenido" class="boton-flecha">
    </div>

    <!-- Duplicación de la sección de "RECETAS COMPRADAS" con las flechas y contenido -->
    <h1 class="subtitulo-recetas">WISHLIST</h1>

    <!-- Contenedor de las flechas y contenido -->
    <div class="contenedor-flechas">
        <!-- Imagen para cambiar contenido hacia atrás -->
        <img src="flecha_izquierda.jpg" alt="Contenido anterior" id="contenidoAnterior2" class="boton-flecha">

        <!-- Contenedor principal de contenido dinámico -->
        <div id="contenido2" class="contenido">
            <p>-Todavía no se han añadido recetas a favoritas-.</p>
        </div>

        <!-- Imagen para cambiar contenido hacia adelante -->
        <img src="flecha_derecha.jpg" alt="Cambiar contenido" id="cambiarContenido2" class="boton-flecha">
    </div>

    <script>
        $(document).ready(function() {
            // Contador para llevar la cuenta de las veces que se hace clic en la primera sección
            let contador = 0;

            // Array con los diferentes contenidos
            const contenidos = [
                '<p>Este es el primer contenido.</p>',
                '<p>Este es el segundo contenido.</p>',
                '<p>Este es el tercer contenido.</p>'
            ];

            // Cuando se haga clic en la flecha derecha, se cambiará el contenido hacia adelante en la primera sección
            $('#cambiarContenido').click(function() {
                // Cambiar el contenido según el contador
                $('#contenido').html(contenidos[contador]);

                // Incrementar el contador (y resetearlo cuando llegue al final del array)
                contador = (contador + 1) % contenidos.length;
            });

            // Cuando se haga clic en la flecha izquierda, se cambiará el contenido hacia atrás en la primera sección
            $('#contenidoAnterior').click(function() {
                // Cambiar el contenido según el contador (restar uno para retroceder)
                contador = (contador - 1 + contenidos.length) % contenidos.length;
                $('#contenido').html(contenidos[contador]);
            });

            // Contador para la segunda sección
            let contador2 = 0;

            // Cuando se haga clic en la flecha derecha, se cambiará el contenido hacia adelante en la segunda sección
            $('#cambiarContenido2').click(function() {
                // Cambiar el contenido según el contador
                $('#contenido2').html(contenidos[contador2]);

                // Incrementar el contador (y resetearlo cuando llegue al final del array)
                contador2 = (contador2 + 1) % contenidos.length;
            });

            // Cuando se haga clic en la flecha izquierda, se cambiará el contenido hacia atrás en la segunda sección
            $('#contenidoAnterior2').click(function() {
                // Cambiar el contenido según el contador (restar uno para retroceder)
                contador2 = (contador2 - 1 + contenidos.length) % contenidos.length;
                $('#contenido2').html(contenidos[contador2]);
            });
        });
    </script>
</body>

</html>
