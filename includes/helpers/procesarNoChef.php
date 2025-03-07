<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = htmlspecialchars($_POST["dni"]);
    $cuentaBancaria = htmlspecialchars($_POST["cuentaBancaria"]);

    // Aquí guardamos los datos en la base de datos o enviarlos por correo

    //echo "Formulario enviado correctamente. Nos pondremos en contacto contigo.";
    header("Location: index.php");
    exit();
}
?>