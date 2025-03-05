//Esta funcion sirve para añadir y eliminar las etiquetas
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
        // Crear el contenedor (div) de la etiqueta
        const etiqueta = document.createElement("div");
        etiqueta.classList.add("etiqueta");
        etiqueta.textContent = texto;

        // Botón para eliminar (x) dentro la etiqueta
        const btnEliminar = document.createElement("button");
        btnEliminar.textContent = "✖";
        btnEliminar.classList.add("btn-eliminar");
        btnEliminar.addEventListener("click", function () { //funcion para que al pulsar sobre el botons e borre la etiqueta
            etiqueta.remove();
        });

        etiqueta.appendChild(btnEliminar);
        contenedorEtiquetas.appendChild(etiqueta);
    }
});

//Esta funcion permite la seleccion de las estrellas
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

    function actualizarEstrellas(valor) { //recorre las estrellas y si su valor es menos o igual
                                          //al seleccionado, le añade la clase seleccionada
        estrellas.forEach(estrella => {
            estrella.classList.remove("seleccionada");
            if (estrella.getAttribute("data-value") <= valor) {
                estrella.classList.add("seleccionada");
            }
        });
    }
});

//Funcion que ajusta el valor minimo y maximo de los precios
document.addEventListener("DOMContentLoaded", function() {
    //recoge los precios seleccionados
    const precioMinInput = document.getElementById("precioMin");
    const precioMaxInput = document.getElementById("precioMax");

    
    precioMinInput.addEventListener("input", function() {
        //convierte los valores de los inputs a numeros enteros
        let precioMin = parseInt(precioMinInput.value, 10) || 0;
        let precioMax = parseInt(precioMaxInput.value, 10) || 0;
        //si el precio max es menor al minimo, actualiza el valor del precio max para que siempre sea 
        //mayor al minimp
        if (precioMax <= precioMin) {
            precioMaxInput.value = precioMin + 1;
        }

        precioMaxInput.min = precioMin + 1; // Ajustamos el mínimo permitido para precio máximo
    });
});