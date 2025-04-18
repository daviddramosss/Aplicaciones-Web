<?php

// Se define el título de la página
$tituloPagina = 'Sobre Nosotros';

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    <!-- Enlace a la hoja de estilos específica para esta página -->

    <!-- Título principal centrado de la página -->
    <h1>Sobre Nosotros</h1>
    
    <!-- Sección de miembros del proyecto -->
    <section class="sobre_nosotros_tarjeta">
        <div class="sobre_nosotros_equipo">
            <h1>Nuestro equipo</h1>
        </div>
        <div class="sobre_nosotros_enlaces">
            <!-- Lista con enlaces internos a cada miembro -->
            <a href="#miembro1">Francisco José Sánchez de León Acevedo</a>  
            <a href="#miembro2">José Pavón Martínez</a> 
            <a href="#miembro3">David Ramos de Lucas</a>    
            <a href="#miembro4">Antonio López Belinchón</a> 
            <a href="#miembro5">Nicolás López-Chavés Pérez</a>  
        </div>
    </section>

    <!-- Información de cada miembro con su imagen, email, rol y aficiones -->
    <div class="container">
    <section id="miembro1" class="sobre_nosotros_miembro">
        <div class="sobre_nosotros_imagen">
            <p><img src="img/FotoFran.jpg" alt="Foto de Francisco" width="150"></p>
        </div>
        <div class="sobre_nosotros_info">
            <h2>Francisco José Sánchez de León Acevedo</h2>
            <p><strong>Email:</strong> francs10@ucm.es</p>
            <p><strong>Rol en el proyecto:</strong> Desarrollador Frontend.</p>
            <p><strong>Aficiones:</strong> Me gusta el mundo de la informática, las empresas y la automoción. 
            Siempre estoy intentando aprender cosas nuevas, tal y como ocurre con este proyecto relacionado con la cocina. 
            Disfruto mucho pasando tiempo con amigos y conociendo gente nueva.</p>
        </div>
        </section>
        
    <section id="miembro2" class="sobre_nosotros_miembro">
        <div class="sobre_nosotros_imagen">
            <p><img src="img/FotoJose.jpg" alt="Foto de José" width="150"></p>
        </div>
        <div class="sobre_nosotros_info">  
            <h2>José Pavón Martínez</h2>
            <p><strong>Email:</strong> jpavon02@ucm.es</p>
            <p><strong>Rol en el proyecto:</strong> Desarrollador Backend.</p>
            <p><strong>Aficiones:</strong> Me gustan los retos, la informática y la comida. 
            Procuro ser el mejor en lo que hago, algo que me mantiene muy ocupado. Disfruto pasando tiempo jugando con colegas.</p>
        </div>
    </section>

    <section id="miembro3" class="sobre_nosotros_miembro">
        <div class="sobre_nosotros_imagen">
            <p><img src="img/FotoDavid.jpg" alt="Foto de David" width="150"></p>
        </div>
         <div class="sobre_nosotros_info">  
            <h2>David Ramos de Lucas</h2>  
            <p><strong>Email:</strong> daramo02@ucm.es</p>
            <p><strong>Rol en el proyecto:</strong> Administrador de Base de Datos (DBA).</p>
            <p><strong>Aficiones:</strong> Me apasiona el fútbol, tanto verlo como jugarlo. En mi tiempo libre, disfruto de los videojuegos, explorando distintos géneros y desafíos. 
                Además, estudio informática, lo que me permite combinar mi interés por la tecnología con el aprendizaje y la resolución de problemas digitales.</p>
        </div>
    </section>

    <section id="miembro4" class="sobre_nosotros_miembro">
        <div class="sobre_nosotros_imagen">
            <p><img src="img/FotoAntonio.jpg" alt="Foto de Antonio" width="150"></p>
        </div>    
        <div class="sobre_nosotros_info">  
            <h2>Antonio López Belinchón</h2>
            <p><strong>Email:</strong> antonl11@ucm.es</p>
            <p><strong>Rol en el proyecto:</strong> Project Manager.</p>
            <p><strong>Aficiones:</strong> Me encanta hacer deporte, jugar videojuegos, escuchar música y pasar tiempo con mis amigos. 
                Disfruto manteniéndome activo, ya sea en el gimnasio o al aire libre, relajarme con buena música y compartir momentos con mis amigos.</p>
        </div>
    </section>

    <section id="miembro5" class="sobre_nosotros_miembro">
        <div class="sobre_nosotros_imagen">
            <p><img src="img/FotoNico.jpg" alt="Foto de Nicolás" width="150"></p>
        </div>
        <div class="sobre_nosotros_info">
            <h2>Nicolás López-Chaves Pérez</h2>
            <p><strong>Email:</strong> nilopez03@ucm.es</p>
            <p><strong>Rol en el proyecto:</strong> Diseñador UX/UI.</p>
            <p><strong>Aficiones:</strong> Me considero una persona apasionada del fútbol, me gusta tanto verlo como jugarlo, también disfruto de otros deportes como el pádel y el golf. 
                Valoro mucho pasar tiempo con mi familia y amigos, ya que para mí es importante equilibrar el deporte con buenos momentos en compañía.</p>
        </div>
    </section>
    </div>
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");

?>
