<?php
// Se incluye el archivo de la clase base 'formularioBase'
include __DIR__ . '/../comun/formularioBase.php';

// Definición de la clase 'contactoFormulario' que extiende de 'formularioBase', heredando su funcionalidad
class noChefFormulario extends formularioBase
{
    // Constructor de la clase que llama al constructor de la clase base ('formularioBase') con el nombre del formulario
    public function __construct() 
    {
        parent::__construct('noChefFormulario');
    }

    // Método protegido que crea los campos del formulario de contacto
    protected function CreateFields($datos)
    {
        // Generación del HTML para el formulario de contacto
        $html = <<<EOF
        <!-- Enlace al archivo CSS específico para el formulario de contacto -->
        <link rel="stylesheet" href="CSS/contacto.css">
        
        <!-- Título de la sección de contacto -->
        <h1>¡CONVIERTETE EN UN CHEF ESTRELLA MICHELIN!</h1>

        <!-- Descripción breve sobre cómo contactar -->
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
