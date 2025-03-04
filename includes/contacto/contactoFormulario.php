<?php
include __DIR__ . '/../comun/formularioBase.php';

class contactoFormulario extends formularioBase
{
    public function __construct() 
    {
        parent::__construct('contactoFormulario');
    }

    protected function CreateFields($datos)
    {
        $html = <<<EOF
        <link rel="stylesheet" href="CSS/contacto.css">
        <h1>CONTACT</h1>
        <p>PARA CONTACTARNOS RELLENE ESTE FORMULARIO.</p>
        <form id="contactoFormulario" method="POST" action="procesarContacto.php">
            <div class="input-container"><input type="text" name="nombre" placeholder="NOMBRE" required></div>
            <div class="input-container"><input type="email" name="correo" placeholder="EMAIL" required></div>
            <div class="input-container"><input type="tel" name="telefono" placeholder="TELÉFONO" required></div>
            <div class="input-container"><textarea name="mensaje" placeholder="MESSAGE (If you have any queries or issues regarding a placed order, please tell us in your message so that we can expedite your case. Thank you very much.)" required></textarea></div>
            <button type="submit" class="send-button">ENVIAR</button>
        </form>

       
        <script src="JS/contacto.js"></script>
        EOF;
        return $html;
    }
}
?>