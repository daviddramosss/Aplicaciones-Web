
// #region Buscar   

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("buscarFormulario");
    

    cargarRecetas();

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Evitar que se recargue la página

        const formData = new FormData(form);

        cargarRecetas(formData);
    });
       
}); 

function cargarRecetas(formData = null) {

    const resultadosDiv = document.getElementById("resultados_buscar_div");

    fetch("includes/endpoints/busquedaDinamica.php", {
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
        resultadosDiv.innerHTML = generaHTMLRecetas(data);
    })
    .catch(error => console.error("Error en la búsqueda:", error));
}

// Función que genera el HTML de las recetas en función del array de recetas
function generaHTMLRecetas(recetas) {

    if (!recetas || recetas.length === 0) {
        return "<p>No existen recetas que cumplan esos criterios.</p>";
    }

    let html = '<div class="recetas-container">';
    
        recetas.forEach(receta =>{
            html += `
            <div class="receta-card">
                <a href="mostrarReceta.php?id=${receta.id}">
                    <img src="img/receta/${receta.ruta}" alt="${receta.nombre}" class="receta-imagen">
                </a>
                <p class="receta-titulo">${receta.nombre}</p>
            </div>
        `;
        });
    
        html += '</div>';
    
    return html;
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