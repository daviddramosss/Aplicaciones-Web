
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link rel="icon" href="img/Logo.png" type="image/png">
    <link rel="stylesheet" media="screen and (min-width: 700px)" type="text/css" href="CSS/estiloPC.css" />
	<link rel="stylesheet" media="screen and (max-width: 699px)" type="text/css" href="CSS/estiloMovil.css" />
    <link rel="stylesheet" href="CSS/estiloGeneral.css">
</head>
<body>
    <div class="contenido_plantilla">
    <!-- La plantilla va a cargar de manera dinámica tanto el título de la pestaña en la que nos encontramos, como el contenido de la misma dejando como contantes la cabecera y el pie -->
        <div class="plantilla_cabecera">
            <?php include 'cabecera.php'; ?>
        </div>

        <div class="contenido_principal">
                <?= $contenidoPrincipal ?>
        </div>
    
        <div class="plantilla_pie">
            <?php include 'pie.php'; ?>
        </div>
    </div> 

</body>
</html>
