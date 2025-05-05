//Esta funcion sirve para pasar los boxes de recetas y de ofertas
document.addEventListener("DOMContentLoaded", function() {
    let recetas = [
        "Receta 1: Pasta Carbonara",
        "Receta 2: Ensalada César",
        "Receta 3: Sopa de Tomate",
        "Receta 4: Pollo al Curry"
    ];

    let ofertas = [
        "Oferta 1: 20% de descuento en recetas de pastas",
        "Oferta 2: 10% de descuento en recetas de postres",
        "Oferta 3: 2x1 en recetas veganas"
    ];

    let recetasVeganas = [
        "Receta Vegana 1: Ensalada de Quinoa",
        "Receta Vegana 2: Hamburguesa de Lentejas",
        "Receta Vegana 3: Leche de Almendras Casera"
    ];

    let recetaIndex = 0;
    let ofertaIndex = 0;
    let veganaIndex = 0;

    // Función para actualizar recetas destacadas
    function actualizarReceta() {
        document.getElementById("recetaDestacada").innerText = recetas[recetaIndex];
    }

    // Función para actualizar ofertas
    function actualizarOferta() {
        document.getElementById("ofertaDestacada").innerText = ofertas[ofertaIndex];
    }

    // Función para actualizar recetas veganas
    function actualizarRecetaVegana() {
        document.getElementById("recetaVegana").innerText = recetasVeganas[veganaIndex];
    }


    // Navegación de recetas
    document.getElementById("nextReceta").addEventListener("click", function() {
        if (recetaIndex < recetas.length - 1) {
            recetaIndex++;
        }
        actualizarReceta();
    });
    
    document.getElementById("prevReceta").addEventListener("click", function() {
        if (recetaIndex > 0) {
            recetaIndex--;
        }
        actualizarReceta();
    });

    // Navegación de ofertas
    document.getElementById("prevOferta").addEventListener("click", function() {
        ofertaIndex = (ofertaIndex - 1 + ofertas.length) % ofertas.length;
        actualizarOferta();
    });

    document.getElementById("nextOferta").addEventListener("click", function() {
        ofertaIndex = (ofertaIndex + 1) % ofertas.length;
        actualizarOferta();
    });


    // Navegación de recetas veganas
    document.getElementById("prevVegana").addEventListener("click", function() {
        veganaIndex = (veganaIndex - 1 + recetasVeganas.length) % recetasVeganas.length;
        actualizarRecetaVegana();
    });

    document.getElementById("nextVegana").addEventListener("click", function() {
        veganaIndex = (veganaIndex + 1) % recetasVeganas.length;
        actualizarRecetaVegana();
    });

    // Cargar contenido inicial
    actualizarReceta();
    actualizarOferta();
    actualizarRecetaVegana();
});