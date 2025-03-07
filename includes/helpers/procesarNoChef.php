<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dni = htmlspecialchars($_POST["dni"]);
        $cuentaBancaria = htmlspecialchars($_POST["cuentaBancaria"]);

        header("Location: index.php");
        exit();
    }
?>