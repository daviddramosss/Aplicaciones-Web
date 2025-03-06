<?php
// Se incluye el archivo de la clase base 'formularioBase'
include __DIR__ . '/../comun/formularioBase.php';

// Definición de la clase 'contactoFormulario' que extiende de 'formularioBase', heredando su funcionalidad
class contactoFormulario extends formularioBase
{
    // Constructor de la clase que llama al constructor de la clase base ('formularioBase') con el nombre del formulario
    public function __construct() 
    {
        parent::__construct('contactoFormulario');
    }

    // Método protegido que crea los campos del formulario de contacto
    protected function CreateFields($datos)
    {
        // Generación del HTML para el formulario de contacto
        $html = <<<EOF
        <!-- Enlace al archivo CSS específico para el formulario de contacto -->
        <link rel="stylesheet" href="CSS/contacto.css">
        
        <!-- Título de la sección de contacto -->
        <h1>CONTACT</h1>

        <!-- Descripción breve sobre cómo contactar -->
        <p>PARA CONTACTARNOS RELLENE ESTE FORMULARIO.</p>

        <!-- Formulario que se enviará a 'procesarContacto.php' -->
        <form id="contactoFormulario" method="POST" action="procesarContacto.php">
            <!-- Campo para ingresar el nombre -->
            <div class="input-container"><input type="text" name="nombre" placeholder="NOMBRE" required></div>

            <!-- Campo para ingresar el correo electrónico -->
            <div class="input-container"><input type="email" name="correo" placeholder="EMAIL" required></div>

            <!-- Campo para ingresar el teléfono -->
            <div class="input-container"><input type="tel" name="telefono" placeholder="TELÉFONO" required></div>

            <!-- Área de texto para ingresar el mensaje -->
            <div class="input-container">
                <textarea name="mensaje" placeholder="MENSAJE (Si tiene alguna consulta debido a la compra de una receta, porfavor comentelo detalladamente para que podamos ayudarle. Muchas gracias)" required></textarea>
            </div>

            <!-- Botón de envío del formulario -->
            <button type="submit" class="send-button">ENVIAR</button>
        </form>

        <!-- Enlace al archivo JS específico para gestionar interacciones en el formulario -->
        <script src="JS/contacto.js"></script>
        EOF;

        // Devuelve el HTML generado para los campos del formulario
        return $html;
    }
}
?>
