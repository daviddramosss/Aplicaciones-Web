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

        btnEliminar.addEventListener("click", function () { //funcion para que al pulsar sobre el boton se borre la etiqueta
            etiqueta.remove();
        });

        etiqueta.appendChild(btnEliminar);
        contenedorEtiquetas.appendChild(etiqueta);
    }
});

//Esta funcion permite la seleccion de las estrellas
document.addEventListener("DOMContentLoaded", function() {

    const estrellas = document.querySelectorAll(".estrella_buscar");
    const valoracionInput = document.getElementById("valoracionInput");

    estrellas.forEach(estrella => {
        estrella.addEventListener("click", function() {

            let valor = this.getAttribute("data-value");

            valoracionInput.value = valor; // Guardamos la calificación

            actualizarEstrellas(valor);
        });
    });

    function actualizarEstrellas(valor) { // Recorre las estrellas y si su valor es menos o igual al seleccionado, le añade la clase seleccionada
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

        //si el precio max es menor al minimo, actualiza el valor del precio max para que siempre sea mayor al minimp
        if (precioMax <= precioMin) {
            precioMaxInput.value = precioMin + 1;
        }

        precioMaxInput.min = precioMin + 1; // Ajustamos el mínimo permitido para precio máximo
    });
});

/* #region BUSQUEDA */

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("buscarFormulario");
    const resultadosDiv = document.getElementById("resultados");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Evitar que se recargue la página

        const formData = new FormData(form);

        // el fetch redirige a la misma página donde estamos

        fetch(window.location.href, {
            method: "POST",
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest" // Indicar que es una petición AJAX
            }
        })
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => {
            resultadosDiv.innerHTML = ""; // Limpiar resultados previos

            if (data.length === 0) {
                resultadosDiv.innerHTML = "<p>No se encontraron resultados.</p>";
                return;
            }

            data.forEach(receta => {
                const recetaDiv = document.createElement("div");
                recetaDiv.classList.add("receta");
                recetaDiv.innerHTML = `
                    <h3>${receta.nombre}</h3>
                    <p>Precio: ${receta.precio}€</p>
                    <p>Valoración: ${receta.valoracion} ★</p>
                `;
                resultadosDiv.appendChild(recetaDiv);
            });
        })
        .catch(error => console.error("Error en la búsqueda:", error));
    });
});


/* #endregion */


// #region SLIDERS

document.addEventListener("DOMContentLoaded", function () {
    const precioMin = document.getElementById("precioMin");
    const precioMax = document.getElementById("precioMax");
    const minOutput = document.getElementById("minValue");
    const maxOutput = document.getElementById("maxValue");

    // Función para actualizar los valores y asegurarse de que no se crucen
    function actualizarSliders() {
        let minVal = parseInt(precioMin.value);
        let maxVal = parseInt(precioMax.value);

        if (minVal > maxVal) {
            precioMax.value = minVal; // Ajustar el máximo si el mínimo lo supera
            maxVal = minVal;
        }

        // Actualizar los valores visibles en pantalla
        minOutput.textContent = minVal;
        maxOutput.textContent = maxVal;
    }

    // Event listeners para detectar cambios
    precioMin.addEventListener("input", actualizarSliders);
    precioMax.addEventListener("input", actualizarSliders);

    // Llamamos una vez la función para que los valores iniciales sean correctos
    actualizarValor();
});


function actualizarValor(idSlider, idTexto) {
    document.getElementById(idTexto).textContent = document.getElementById(idSlider).value;
}


// #endregion