<?php
// Se incluye el archivo de la clase base 'formularioBase'
include __DIR__ . '/../comun/formularioBase.php';

// Definición de la clase 'noChefFormulario' que extiende de 'formularioBase', heredando su funcionalidad
class noChefFormulario extends formularioBase
{
   // Constructor de la clase
    public function __construct() 
    {
        parent::__construct('noChefFormulario');
    }

    // Método protegido que crea los campos del formulario 
    protected function CreateFields($datos)
    {
        // Generación del HTML para el formulario
        $html = <<<EOF
        <!-- Enlace al archivo CSS específico para el formulario de contacto -->
        <link rel="stylesheet" href="CSS/contacto.css">
        
        <!-- Título de la sección de no Chef -->
        <h1>¡Coviertete en un Chef Estrella Michelin!</h1>

        <!-- Descripción breve sobre cómo darse de alta -->
        <p>PARA DARSE DE ALTA RELLENE ESTE FORMULARIO.</p>

        <!-- Formulario que se enviará a 'procesarNoChef.php' -->
        <form id="noChefFormulario" method="POST" action="procesarNoChef.php">
            <!-- Campo para ingresar el dni -->
            <div class="input-container"><input type="text" name="dni" placeholder="DNI" required></div>

            <!-- Campo para ingresar la cuenta bancaria -->
            <div class="input-container"><input type="cuentaBancaria" name="cuentaBancaria" placeholder="CUENTA BANCARIA" required></div>


            <!-- Botón de envío del formulario -->
            <button type="submit" class="send-button">ENVIAR</button>
        </form>

        <!-- Enlace al archivo JS específico para gestionar interacciones en el formulario -->
        <script src="JS/noChef.js"></script>
        EOF;

        // Devuelve el HTML generado para los campos del formulario
        return $html;
    }
}
?>
