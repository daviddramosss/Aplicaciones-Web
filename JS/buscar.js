
// #region Estrellas

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

// #endregion

// #region Buscar   

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("buscarFormulario");
    

    cargarRecetas();

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Evitar que se recargue la página

        const formData = new FormData(form);

        cargarRecetas(formData);
    });
        // el fetch redirige a la misma página donde estamos
       /*  fetch("includes/helpers/buscarHelper.php", {
            method: "POST",
            body: formData,
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.json()) // En lugar de .json(), usa .text() para ver la respuesta completa
        .then(data => {
            console.log("Respuesta del servidor:", data); // Muestra la respuesta en la consola
        //     try {
        //         const jsonData = JSON.parse(data); // Intenta convertirla a JSON
        //         console.log("JSON parseado correctamente:", jsonData);
        //     } catch (error) {
        //         console.error("Error al parsear JSON:", error);
        //     }
        })
        .catch(error => console.error("Error en la búsqueda:", error)); */

        
}); 

function cargarRecetas(formData = null) {

    const resultadosDiv = document.getElementById("resultados_buscar_div");

    fetch("includes/helpers/buscarHelper.php", {
        method: "POST",
        body: formData,
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(response => response.json()) // Convertir a JSON
    .then(data => {
        console.log("Respuesta del servidor:", data);
        resultadosDiv.innerHTML = ""; // Limpiar resultados previos

        if (data.length === 0) {
            resultadosDiv.innerHTML = "<p>No se encontraron resultados.</p>";
            return;
        }

        resultadosDiv.innerHTML = data;
    })
    .catch(error => console.error("Error en la búsqueda:", error));
}


// #endregion

// #region SLIDERS

document.addEventListener("DOMContentLoaded", function () {
    const precioMinInput = document.getElementById("precioMin");
    const precioMaxInput = document.getElementById("precioMax");
    const minOutput = document.getElementById("minValue");
    const maxOutput = document.getElementById("maxValue");

    // Función para actualizar los valores de los sliders y asegurarse de que no se crucen
    function actualizarSliders() {
        let precioMin = parseInt(precioMinInput.value, 10) || 0;
        let precioMax = parseInt(precioMaxInput.value, 10) || 0;

        // Si el valor del máximo es menor que el mínimo, ajustamos el máximo
        if (precioMax <= precioMin) {
            precioMaxInput.value = precioMin + 1;
            precioMax = precioMin + 1; // Actualizamos el valor de maxVal
        }

        // Ajustamos los rangos
        precioMaxInput.min = precioMin + 1; // Ajustar el mínimo permitido para precio máximo

        // Actualizar los valores visibles
        minOutput.textContent = precioMin;
        maxOutput.textContent = precioMax;
    }

    // Event listeners para detectar cambios
    precioMinInput.addEventListener("input", actualizarSliders);
    precioMaxInput.addEventListener("input", actualizarSliders);

    // Llamamos una vez la función para que los valores iniciales sean correctos
    actualizarSliders();
});



function actualizarValor(idSlider, idTexto) {
    document.getElementById(idTexto).textContent = document.getElementById(idSlider).value;
}


// #endregion