<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Chef</title>
    <link rel="stylesheet" href="CSS/index.css">  
</head>
<body>
    <div id="contenedor">
    
        <!-- Plantilla de la página web --> 
        <?php include 'includes/vistas/comun/plantilla.php'; ?>

        <!-- Parte central de la página web -->
        <main> 
            <h1>Market Chef</h1> 

            <!-- Sección de recetas destacadas -->
            <section class="destacadas">
                <h2>Top 10 recetas de hoy</h2>
                <!-- Aqui se mostrará más adelante las recetas del dia de hoy -->
                <div class="contenedor-flechas">
                    <button id="prevReceta" class="boton-flecha">&lt;</button>
                    <div id="recetaDestacada" class="contenido"></div>
                    <button id="nextReceta" class="boton-flecha">&gt;</button>
                </div>
            </section>

            <!-- Sección de ofertas -->
            <section class="ofertas"> 
                <h2>Ofertas</h2>
                <!-- Aqui se mostrara mas adelante las ofertas de las recetas que esten en el momento --> 
                <div class="contenedor-flechas">
                    <button id="prevOferta" class="boton-flecha">&lt;</button>
                    <div id="ofertaDestacada" class="contenido"></div>
                    <button id="nextOferta" class="boton-flecha">&gt;</button>
                </div>
            </section>
        </main>
    </div>

    <script src="JS/script.js"></script>
</body>
</html>