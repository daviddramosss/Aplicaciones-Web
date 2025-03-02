<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link rel="icon" href="img/Logo.png" type="image/x-icon">
</head>
<body>

    <?php include 'cabecera.php'; ?>

    <main>
        <article>
            <?= $contenidoPrincipal ?>
        </article>
    </main>

    <?php include 'pie.php'; ?>

</body>
</html>
