document.addEventListener("DOMContentLoaded", function () {
    const inputEtiqueta = document.getElementById("etiquetas");
    const btnAgregarEtiqueta = document.getElementById("agregarEtiqueta");
    const contenedorEtiquetas = document.getElementById("etiquetasSeleccionadas");

    btnAgregarEtiqueta.addEventListener("click", function () {
        const etiquetaTexto = inputEtiqueta.value.trim();

        if (etiquetaTexto !== "") {
            agregarEtiqueta(etiquetaTexto);
            inputEtiqueta.value = ""; // Limpiar el campo de entrada
        }
    });

    function agregarEtiqueta(texto) {
        // Crear el contenedor de la etiqueta
        const etiqueta = document.createElement("div");
        etiqueta.classList.add("etiqueta");
        etiqueta.textContent = texto;

        // Botón para eliminar la etiqueta
        const btnEliminar = document.createElement("button");
        btnEliminar.textContent = "✖";
        btnEliminar.classList.add("btn-eliminar");
        btnEliminar.addEventListener("click", function () {
            etiqueta.remove();
        });

        etiqueta.appendChild(btnEliminar);
        contenedorEtiquetas.appendChild(etiqueta);
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const estrellas = document.querySelectorAll(".estrella");
    const valoracionInput = document.getElementById("valoracionInput");

    estrellas.forEach(estrella => {
        estrella.addEventListener("click", function() {
            let valor = this.getAttribute("data-value");
            valoracionInput.value = valor; // Guardamos la calificación
            actualizarEstrellas(valor);
        });
    });

    function actualizarEstrellas(valor) {
        estrellas.forEach(estrella => {
            estrella.classList.remove("seleccionada");
            if (estrella.getAttribute("data-value") <= valor) {
                estrella.classList.add("seleccionada");
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const precioMinInput = document.getElementById("precioMin");
    const precioMaxInput = document.getElementById("precioMax");

    precioMinInput.addEventListener("input", function() {
        let precioMin = parseInt(precioMinInput.value, 10) || 0;
        let precioMax = parseInt(precioMaxInput.value, 10) || 0;

        if (precioMax <= precioMin) {
            precioMaxInput.value = precioMin + 1;
        }

        precioMaxInput.min = precioMin + 1; // Ajustamos el mínimo permitido para precio máximo
    });
});