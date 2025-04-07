document.addEventListener("DOMContentLoaded", function () {
    const carruseles = ["swiper-fecha", "swiper-etiqueta", "swiper-precio", "swiper-ingredientes"];

    carruseles.forEach(id => {
        new Swiper(`#${id}`, {
            slidesPerView: 4,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: `#next-${id}`, // Flecha derecha del carrusel específico
                prevEl: `#prev-${id}`,  // Flecha izquierda del carrusel específico
            },
            pagination: {
                el: `#pagination-${id}`, // Paginación específica para este carrusel
                clickable: true,
            },
             breakpoints: {
                1024: { slidesPerView: 4 }, // Pantallas grandes (escritorio)
                768: { slidesPerView: 3 },  // Tablets
                480: { slidesPerView: 1 }   // Teléfonos medianos
            }
        });
    });
});
