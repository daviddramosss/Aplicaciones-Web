<?php
session_start();
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$recetaId = $_POST['recetaId'] ?? null;

if ($recetaId && !in_array($recetaId, $_SESSION['carrito'])) {
    $_SESSION['carrito'][] = $recetaId;
}

header('Location: carrito.php');
exit;

?>