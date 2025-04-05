<?php

// Se define el título de la página
$tituloPagina = 'Términos y Condiciones';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <h1>Términos y Condiciones</h1>
    <div class="container">
    <section>
        <h2>1. Introducción</h2>
        <p>Bienvenido a Market Chef. Al utilizar nuestra plataforma, aceptas cumplir con los siguientes términos y condiciones. 
        Este documento establece los derechos y responsabilidades de los usuarios al interactuar con nuestra web. 
        Por favor, léelo detenidamente antes de continuar. 
        El uso de nuestros servicios implica la aceptación total de estos términos. 
        En caso de desacuerdo, te recomendamos no utilizar la plataforma.</p>
    </section>

    <section>
        <h2>2. Registro y Cuenta de Usuario</h2>
        <p>Para acceder a ciertas funcionalidades, los usuarios deben crear una cuenta proporcionando información veraz. 
        Es responsabilidad del usuario mantener la confidencialidad de sus credenciales. 
        Nos reservamos el derecho de suspender cuentas en caso de actividad sospechosa. 
        No permitimos múltiples cuentas por usuario sin previo consentimiento. 
        Cualquier intento de suplantación de identidad será motivo de cancelación de cuenta.</p>
    </section>

    <section>
        <h2>3. Publicación de Recetas</h2>
        <p>Los usuarios pueden compartir recetas en nuestra plataforma, asegurando que tienen los derechos sobre el contenido. 
        No se permite la publicación de recetas ofensivas, ilegales o plagiadas. 
        Nos reservamos el derecho de eliminar contenido que infrinja estas normas. 
        Las recetas compartidas pueden ser utilizadas con fines promocionales dentro de la plataforma. 
        La calidad y veracidad de la información proporcionada es responsabilidad del usuario.</p>
    </section>

    <section>
        <h2>4. Uso Aceptable</h2>
        <p>El usuario se compromete a utilizar la plataforma de forma ética y legal. 
        No está permitido el uso de Market Chef para actividades fraudulentas o dañinas. 
        Cualquier intento de manipulación de datos o ataque a nuestros sistemas será investigado. 
        Nos reservamos el derecho de restringir el acceso a usuarios que incumplan estas normas. 
        El respeto y la buena convivencia son esenciales en nuestra comunidad.</p>
    </section>

    <section>
        <h2>5. Responsabilidad y Garantías</h2>
        <p>Market Chef no se hace responsable por errores en las recetas o daños derivados del uso de la plataforma. 
        Nos esforzamos por ofrecer un servicio seguro y funcional, pero no garantizamos disponibilidad continua. 
        El usuario es responsable de verificar la calidad e idoneidad de las recetas publicadas. 
        En caso de problemas técnicos, recomendamos contactar con nuestro equipo de soporte. 
        Nos reservamos el derecho de modificar la plataforma en cualquier momento sin previo aviso.</p>
    </section>

    <section>
        <h2>6. Cambios en los Términos</h2>
        <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. 
        Los cambios entrarán en vigor inmediatamente tras su publicación en la web. 
        Se notificará a los usuarios sobre modificaciones importantes mediante correo electrónico o anuncios en la plataforma. 
        Es responsabilidad del usuario revisar periódicamente los términos actualizados. 
        El uso continuado de la plataforma implica la aceptación de los cambios.</p>
    </section>
    </div>
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
