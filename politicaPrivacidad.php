<?php

// Se define el título de la página
$tituloPagina = 'Política de Privacidad';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <link rel="stylesheet" href="CSS/privacidad.css">
    <h1 class="titulo-centrado">Política de Privacidad</h1>

    <h2>1. Introducción</h2>
    <p>En Market Chef, nos tomamos muy en serio la privacidad de nuestros usuarios. 
    Esta Política de Privacidad explica cómo recopilamos, usamos y protegemos tu información personal. 
    Al utilizar nuestra plataforma, aceptas las prácticas descritas en esta política. 
    Si tienes alguna duda sobre el tratamiento de tus datos, puedes contactarnos en cualquier momento. 
    Nos reservamos el derecho de modificar esta política, por lo que te recomendamos revisarla periódicamente.</p>

    <h2>2. Información que Recopilamos</h2>
    <p>Podemos recopilar información personal como tu nombre, dirección de correo electrónico y número de teléfono. 
    También almacenamos información sobre tus interacciones en nuestra plataforma, como recetas publicadas y comentarios. 
    Usamos cookies y tecnologías similares para mejorar tu experiencia en Market Chef. 
    No recopilamos datos sensibles sin tu consentimiento expreso. 
    Toda la información se almacena de manera segura y solo se usa con fines legítimos.</p>

    <h2>3. Uso de la Información</h2>
    <p>Utilizamos tu información para ofrecerte un mejor servicio y mejorar la plataforma. 
    Esto incluye personalizar tu experiencia, enviarte notificaciones y responder a tus consultas. 
    También podemos usar los datos para analizar tendencias y optimizar nuestras funcionalidades. 
    No compartimos tu información con terceros sin tu autorización, excepto en los casos permitidos por la ley. 
    Nos comprometemos a utilizar tus datos de manera ética y transparente.</p>

    <h2>4. Protección de Datos</h2>
    <p>Implementamos medidas de seguridad para proteger tu información contra accesos no autorizados. 
    Utilizamos cifrado y protocolos seguros para proteger los datos almacenados en nuestra plataforma. 
    Sin embargo, ningún sistema es completamente infalible, por lo que no podemos garantizar seguridad absoluta. 
    Si detectamos una brecha de seguridad, te notificaremos a la brevedad posible. 
    Es importante que tomes precauciones como usar contraseñas seguras y no compartir tu cuenta.</p>

    <h2>5. Derechos del Usuario</h2>
    <p>Tienes derecho a acceder, modificar o eliminar tu información personal en cualquier momento. 
    También puedes solicitar que limitemos el uso de tus datos o que los transfiramos a otra plataforma. 
    Si deseas ejercer estos derechos, puedes contactarnos a través de nuestra página de contacto. 
    Respetamos tu privacidad y trabajamos para garantizar que tengas control sobre tu información. 
    Si crees que hemos incumplido esta política, puedes presentar una queja ante las autoridades correspondientes.</p>

    <h2>6. Contacto</h2>
    <p>Si tienes preguntas sobre nuestra Política de Privacidad, puedes comunicarte con nosotros. 
    Estamos comprometidos en brindarte transparencia y seguridad en el uso de Market Chef. 
    Nuestra prioridad es proteger tu información y garantizarte una experiencia confiable. 
    Te recomendamos leer esta política regularmente para estar informado sobre cualquier cambio. 
    Gracias por confiar en nosotros y ser parte de nuestra comunidad.</p>
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");
?>