document.addEventListener("DOMContentLoaded", function() {
    
    // Lista de ofertas disponibles (por ahora con datos de prueba)
    let ofertas = [
        "-TODAVÍA NO HAY RECETAS EN VENTA ................-",
        "2",
        "3"
    ];

    // Índice que controla la oferta actualmente mostrada
    let ofertaIndex = 0;

    // Función para actualizar la oferta destacada en la interfaz
    function actualizarOferta() {
        document.getElementById("ofertaDestacada").innerText = ofertas[ofertaIndex];
    }

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
    actualizarOferta();
});
