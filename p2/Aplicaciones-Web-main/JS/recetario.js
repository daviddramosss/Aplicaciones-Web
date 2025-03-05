document.addEventListener("DOMContentLoaded", function() {
    let recetas = [
        "-Todavia no se han comprado recetas-",
        "2",
        "3",
        "4",
        "5"
    ];

    let ofertas = [
        "-Todavia no se han destacado recetas-",
        "2",
        "3"
    ];

    let recetaIndex = 0;
    let ofertaIndex = 0;

    // Función para actualizar recetas destacadas
    function actualizarReceta() {
        document.getElementById("recetaDestacada").innerText = recetas[recetaIndex];
    }

    // Función para actualizar ofertas
    function actualizarOferta() {
        document.getElementById("ofertaDestacada").innerText = ofertas[ofertaIndex];
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

    // Cargar contenido inicial
    actualizarReceta();
    actualizarOferta();
});