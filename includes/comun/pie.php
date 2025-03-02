<?php
// footer.php - Archivo de pie de página con enlaces y redes sociales
?>
<footer class="footer">
    <div class="container_footer">
        <!-- Sección de enlaces principales -->
        <div class="footer_links">
            <a href="sobreNosotros.php">Sobre Nosotros</a>
            <a href="contacto.php">Contacto</a>
            <a href="terminos.php">Términos y Condiciones</a>
            <a href="politicaPrivacidad.php">Política de Privacidad</a>
        </div>

        <!-- Redes sociales -->
        <div class="footer_social">
            <a href="https://facebook.com" target="_blank">
                <img src="img/facebook.png" alt="Facebook">
            </a>
            <a href="https://twitter.com" target="_blank">
                <img src="img/twitter.png" alt="Twitter">
            </a>
            <a href="https://instagram.com" target="_blank">
                <img src="img/instagram.png" alt="Instagram">
            </a>
        </div>

        <!-- Derechos de autor -->
        <div class="footer_copy">
            <p>&copy; <?php echo date("Y"); ?> Market Chef. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
<link rel="stylesheet" href="CSS/footer.css">
