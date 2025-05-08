<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tituloPagina) ?></title>
    <link rel="icon" href="img/Logo.png" type="image/png">
</head>
<body>
    <?php include 'cabecera.php'; ?>

    <main class="contenido-plantilla">
        <article>
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p style='color:red;'>" . htmlspecialchars($_SESSION['error']) . "</p>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo "<p style='color:green;'>" . htmlspecialchars($_SESSION['success']) . "</p>";
                unset($_SESSION['success']);
            }
            ?>
            <?= $contenidoPrincipal ?>
        </article>
    </main>

    <?php include 'pie.php'; ?>
    <?= isset($scripts) ? $scripts : '' ?>
</body>
</html>