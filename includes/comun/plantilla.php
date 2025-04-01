
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link rel="icon" href="img/Logo.png" type="image/png">
    <link rel="stylesheet" href="CSS/estiloGeneral.css">

    

</head>
<body>
    <main class="contenido.plantilla"></main>
    <!-- La plantilla va a cargar de manera dinámica tanto el título de la pestaña en la que nos encontramos, como el contenido de la misma dejando como contantes la cabecera y el pie -->
    <div class="plantilla_cabecera">
        <?php include 'cabecera.php'; ?>
    </div>

    
        <div class="contenido_principal">
            <article>
                <?= $contenidoPrincipal ?>
            </article>
        </div>
    

    <?php include 'pie.php'; ?>
    </main> 

</body>
</html>
