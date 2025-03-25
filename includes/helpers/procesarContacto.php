<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre = htmlspecialchars($_POST["nombre"]);
        $correo = htmlspecialchars($_POST["correo"]);
        $telefono = htmlspecialchars($_POST["telefono"]);

        header("Location: index.php");
        exit();
    }
?>