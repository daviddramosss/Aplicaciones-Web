<?php
$esAdmin = false;
require_once("includes/usuario/userDAO.php");
require_once("includes/usuario/userFactory.php");

// Comprobamos si el usuario está logueado y tiene el rol de Admin
if (isset($_SESSION["login"])) {
    $IUserDAO = userFactory::CreateUser();
    $foundedUserDTO = $IUserDAO->buscaUsuario($_SESSION["usuario"]);
    if($foundedUserDTO){
        if($foundedUserDTO->rol() == "Admin"){
            $esAdmin = true;
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link rel="icon" href="img/Logo.png" type="image/png">
</head>
<body>

    <?php include 'cabecera.php'; ?>
    <?php if ($esAdmin): ?>
        <?php include 'sideBarIzq.php'; ?>
    <?php endif; ?>
    <main>
        <article>
            <?= $contenidoPrincipal ?>
        </article>
    </main>

    <?php include 'pie.php'; ?>

</body>
</html>
