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

    <h2 id="miembro1">Francisco José Sánchez de León Acevedo</h2>
    <p> <img src="img/FotoFran.jpg" alt="Foto de Francisco" width="150">
    <p><strong>Email:</strong> francs10@ucm.es</p>
    <p><strong>Rol en el proyecto:</strong> Desarrollador Frontend.</p>
    <p><strong>Aficiones:</strong> Me gusta el mundo de la informática, las empresas y la automoción. 
        Siempre estoy intentando aprender cosas nuevas, tal y como ocurre con este proyecto relacionado con la cocina. 
        Disfruto mucho pasando tiempo con amigos y conociendo gente nueva.</p></p>

    <h2 id="miembro2"> José Pavón Martinez</h2>
    <p><img src="img/FotoJose.jpg" alt="Foto de José" width="150">
    <p><strong>Email:</strong> jpavon02@ucm.es</p>
    <p><strong>Rol en el proyecto:</strong> Desarrollador Backend.</p>
    <p><strong>Aficiones:</strong> Me gustan los retos, la informática y la comida. 
        Procuro ser lo mejor en lo que hago, algo que me mantiene muy ocupado. Disfruto pasando tiempo jugando con colegas.</p></p>

    <h2 id="miembro3">David Ramos de Lucas</h2>
    <p><img src="img/FotoDavid.jpg" alt="Foto de David" width="150">
    <p><strong>Email:</strong> daramo02@ucm.es</p>
    <p><strong>Rol en el proyecto:</strong> Administrador de Base de Datos (DBA).</p>
    <p><strong>Aficiones:</strong> Me apasiona el fútbol, tanto verlo como jugarlo. En mi tiempo libre, disfruto de los videojuegos, explorando distintos géneros y desafíos. 
        Además, estudio informática, lo que me permite combinar mi interés por la tecnología con el aprendizaje y la resolución de problemas digitales.</p></p>

    <h2 id="miembro4">Antonio López Belinchón</h2>
    <p> <img src="img/FotoAntonio.jpg" alt="Foto de Antonio" width="150">
    <p><strong>Email:</strong> antonl11@ucm.es</p>
    <p><strong>Rol en el proyecto:</strong> Project Manager.</p>
    <p><strong>Aficiones:</strong> Me encanta hacer deporte, jugar videojuegos, escuchar música y pasar tiempo con mis amigos. 
        Disfruto manteniendome activo, ya sea en el gimnasio o al aire libre, relajarme con buena música, y compartir momentos con mis amigos.</p>
</p>

    <h2 id="miembro5"> Nicolás López-Chaves Pérez</h2>
    <p><img src="img/FotoNico.jpg" alt="Foto de Nicolás" width="150">
    <p><strong>Email:</strong> nilopez03@ucm.es</p>
    <p><strong>Rol en el proyecto:</strong> Diseñador UX/UI.</p>
    <p><strong>Aficiones:</strong> Me considero una persona apasionada del fútbol, me gusta tanto verlo como jugarlo, también disfruto de otros deportes como el pádel y el golf. 
        Valoro mucho pasar tiempo con mi familia y amigos, ya que para mí es importante equilibrar el deporte con buenos momentos en compañía.</p></p>
EOS;

require("includes/comun/plantilla.php");
?>
