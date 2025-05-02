<?php
session_start();

$recetaId = $_POST['recetaId'] ?? null;

if ($recetaId !== null && isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array_filter($_SESSION['carrito'], fn($id) => $id != $recetaId);
    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['success' => false]);
