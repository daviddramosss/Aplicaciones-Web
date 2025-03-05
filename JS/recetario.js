// Espera a que el DOM se cargue completamente antes de ejecutar el código
document.addEventListener("DOMContentLoaded", function() {

    // Listado de recetas compradas (por ahora, con datos de prueba)
    let recetas = [
        "-Todavía no se han comprado recetas-",
        "2",
        "3",
        "4",
        "5"
    ];

    // Listado de recetas destacadas en la sección de ofertas (por ahora, con datos de prueba)
    let ofertas = [
        "-Todavía no se han destacado recetas-",
        "2",
        "3"
    ];

    // Índices para controlar la receta y oferta mostrada actualmente
    let recetaIndex = 0;
    let ofertaIndex = 0;

    // Función para actualizar la receta destacada en la interfaz
    function actualizarReceta() {
        document.getElementById("recetaDestacada").innerText = recetas[recetaIndex];
    }

    // Función para actualizar la oferta destacada en la interfaz
    function actualizarOferta() {
        document.getElementById("ofertaDestacada").innerText = ofertas[ofertaIndex];
    }

    // Manejo de la navegación de recetas (siguiente)
    document.getElementById("nextReceta").addEventListener("click", function() {
        if (recetaIndex < recetas.length - 1) {
            recetaIndex++; // Avanza al siguiente índice si no está en el final
        }
        actualizarReceta();
    });

    // Manejo de la navegación de recetas (anterior)
    document.getElementById("prevReceta").addEventListener("click", function() {
        if (recetaIndex > 0) {
            recetaIndex--; // Retrocede al índice anterior si no está en el inicio
        }
        actualizarReceta();
    });

    // Manejo de la navegación de ofertas (anterior)
    document.getElementById("prevOferta").addEventListener("click", function() {
        // Usa aritmética modular para hacer que la navegación sea circular
        ofertaIndex = (ofertaIndex - 1 + ofertas.length) % ofertas.length;
        actualizarOferta();
    });

    // Manejo de la navegación de ofertas (siguiente)
    document.getElementById("nextOferta").addEventListener("click", function() {
        // Usa aritmética modular para hacer que la navegación sea circular
        ofertaIndex = (ofertaIndex + 1) % ofertas.length;
        actualizarOferta();
    });

    // Cargar el contenido inicial en la interfaz
    actualizarReceta();
    actualizarOferta();
});
