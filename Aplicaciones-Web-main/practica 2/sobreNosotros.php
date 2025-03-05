<?php
$tituloPagina = 'Sobre Nosotros';

$contenidoPrincipal = <<<EOS
    <link rel="stylesheet" href="CSS/terminos.css">
    <h1 class="titulo-centrado">Sobre Nosotros</h1>
    
    <h2>1. Miembros</h2>
    <h1>Participantes del Proyecto</h1>
    <ul>
        <li><a href="#miembro1">Francisco José Sánchez de León Acevedo</a></li>
        <li><a href="#miembro2">José Pavón Martínez</a></li>
        <li><a href="#miembro3">David Ramos de Lucas</a></li>
        <li><a href="#miembro4">Antonio López Belinchón</a></li>
        <li><a href="#miembro5">Nicolás López-Chavés Pérez</a></li>
    </ul>

    <h2>Francisco José Sánchez de León Acevedo</h2>
    <p> <img src="img/FotoFran.jpg" alt="Foto de Francisco" width="150">
    <p><strong>Email:</strong> francs10@ucm.es</p>
    <p><strong>Rol en el proyecto:</strong> Desarrollador Frontend.</p>
    <p><strong>Aficiones:</strong> Me gusta el mundo de la informática, las empresas y la automoción. 
        Siempre estoy intentando aprender cosas nuevas, tal y como ocurre con este proyecto relacionado con la cocina. 
        Disfruto mucho pasando tiempo con amigos y conociendo gente nueva.</p></p>

    <h2>3. Publicación de Recetas</h2>
    <p>Los usuarios pueden compartir recetas en nuestra plataforma, asegurando que tienen los derechos sobre el contenido. 
    No se permite la publicación de recetas ofensivas, ilegales o plagiadas. 
    Nos reservamos el derecho de eliminar contenido que infrinja estas normas. 
    Las recetas compartidas pueden ser utilizadas con fines promocionales dentro de la plataforma. 
    La calidad y veracidad de la información proporcionada es responsabilidad del usuario.</p>

    <h2>4. Uso Aceptable</h2>
    <p>El usuario se compromete a utilizar la plataforma de forma ética y legal. 
    No está permitido el uso de Market Chef para actividades fraudulentas o dañinas. 
    Cualquier intento de manipulación de datos o ataque a nuestros sistemas será investigado. 
    Nos reservamos el derecho de restringir el acceso a usuarios que incumplan estas normas. 
    El respeto y la buena convivencia son esenciales en nuestra comunidad.</p>

    <h2>5. Responsabilidad y Garantías</h2>
    <p>Market Chef no se hace responsable por errores en las recetas o daños derivados del uso de la plataforma. 
    Nos esforzamos por ofrecer un servicio seguro y funcional, pero no garantizamos disponibilidad continua. 
    El usuario es responsable de verificar la calidad e idoneidad de las recetas publicadas. 
    En caso de problemas técnicos, recomendamos contactar con nuestro equipo de soporte. 
    Nos reservamos el derecho de modificar la plataforma en cualquier momento sin previo aviso.</p>

    <h2>6. Cambios en los Términos</h2>
    <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. 
    Los cambios entrarán en vigor inmediatamente tras su publicación en la web. 
    Se notificará a los usuarios sobre modificaciones importantes mediante correo electrónico o anuncios en la plataforma. 
    Es responsabilidad del usuario revisar periódicamente los términos actualizados. 
    El uso continuado de la plataforma implica la aceptación de los cambios.</p>
EOS;

require("includes/comun/plantilla.php");
?>
