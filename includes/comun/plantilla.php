
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link rel="icon" href="img/Logo.png" type="image/png">
    <link rel="stylesheet" href="CSS/estiloGeneral.css">

     <!-- Swiper CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

</head>
<body>

    <!-- La plantilla va a cargar de manera dinámica tanto el título de la pestaña en la que nos encontramos, como el contenido de la misma dejando como contantes la cabecera y el pie -->
    <?php include 'cabecera.php'; ?>

    <main class="contenido.plantilla">
        <article>
            <?= $contenidoPrincipal ?>
        </article>
    </main>

    <?php include 'pie.php'; ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    
    <!-- Se incluye el archivo JavaScript específico para manejar las interacciones en la página de inicio -->
    <script src="JS/index.js"></script>

</body>
</html>
