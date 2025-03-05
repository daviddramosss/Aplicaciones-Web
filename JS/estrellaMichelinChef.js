document.addEventListener("DOMContentLoaded", function() {
   

    let ofertas = [
        "-TODAVIA NO HAY RECETAS EN VENTA ................-",
        "2",
        "3"
    ];

    let ofertaIndex = 0;

    
    // Función para actualizar ofertas
    function actualizarOferta() {
        document.getElementById("ofertaDestacada").innerText = ofertas[ofertaIndex];
    }

    
    
   

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
    actualizarOferta();
});