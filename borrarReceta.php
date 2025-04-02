<?php
// Incluir archivos necesarios
require_once("includes/config.php");

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Obtener el ID de la receta desde el formulario
    $recetaId = intval($_POST['id']);

    // Lógica para borrar la receta
    $recetaService = recetaAppService::GetSingleton(); // Asegúrate de instanciar tu servicio de recetas
    $resultado = $recetaService->borrarReceta($recetaId); // Llama al método para borrar la receta

    // Verificar el resultado de la operación
    if ($resultado) {
        // Redirigir a una página de éxito o mostrar un mensaje
        header("Location: recetas.php?mensaje=Receta borrada con éxito");
        exit();
    } else {
        // Manejar el error, redirigir o mostrar un mensaje de error
        echo "Error al borrar la receta. Por favor, inténtalo de nuevo.";
    }
} else {
    // Si no se envió el formulario, redirigir a la página de recetas
    header("Location: recetas.php");
    exit();
}
?>