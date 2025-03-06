<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $correo = htmlspecialchars($_POST["correo"]);
    $telefono = htmlspecialchars($_POST["telefono"]);

    // Aquí guardamos los datos en la base de datos o enviarlos por correo

    //echo "Formulario enviado correctamente. Nos pondremos en contacto contigo.";
    header("Location: index.php");
    exit();
}
?>