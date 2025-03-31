document.addEventListener("DOMContentLoaded", function() {
    let stepCounter = 1; // Comienza en 1 porque ya hay un paso inicial
    const maxEtiquetas = 3; // Número máximo de etiquetas permitidas

    let stepsContainer = document.getElementById("stepsContainer");
    let addStepButton = document.getElementById("addStep");
    let removeStepButton = document.getElementById("removeStep");

    // Cargar los pasos previamente guardados
    if (typeof pasosGuardados !== "undefined" && pasosGuardados.length > 0) {
        stepsContainer.innerHTML = ""; // Limpiar contenido previo
        pasosGuardados.forEach((paso, index) => {
            agregarPaso(index + 1, paso); // Agregar cada paso desde PHP
        });
        stepCounter = pasosGuardados.length; // Ajustar el contador
    }

    // Función para agregar un nuevo paso
    function agregarPaso(numero, texto = "") {
        let newStep = document.createElement("p");
        newStep.classList.add("step-item");
        newStep.innerHTML = `<label>Paso ${numero}:</label> 
                             <textarea name="steps[]" required>${texto}</textarea>`;
        stepsContainer.appendChild(newStep);
    }

    // Evento para añadir un nuevo paso manualmente
    addStepButton.addEventListener("click", function () {
        stepCounter++;
        agregarPaso(stepCounter);
    });

    // Evento para eliminar el último paso agregado
    removeStepButton.addEventListener("click", function () {
        let steps = stepsContainer.getElementsByClassName("step-item");
        if (steps.length > 0) {
            stepsContainer.removeChild(steps[steps.length - 1]);
            stepCounter--;
        }
    });

    // Referencias a los elementos del precio y del ingreso estimado
    let precioInput = document.querySelector('input[name="precio"]');
    let ingresoEstimadoSpan = document.getElementById("ingresoEstimado");

    // Función para actualizar el ingreso estimado basado en el precio ingresado
    function actualizarIngresoEstimado() {
        let precio = parseFloat(precioInput.value) || 0; // Convierte el valor a número
        let ingresoEstimado = precio * 0.85; // Aplica el 15% de comisión (se queda con el 85%)
        ingresoEstimadoSpan.textContent = ingresoEstimado.toFixed(2); // Muestra el resultado con 2 decimales
    }
    // Llamamos a la función al inicio para precargar el valor
    actualizarIngresoEstimado();

    // Evento para actualizar el ingreso estimado cuando el usuario cambia el precio
    precioInput.addEventListener("input", actualizarIngresoEstimado);
});

//Evento para mostrar imagen cargada
document.getElementById("imagenReceta").addEventListener("change", function (event) {
    const previewImage = document.getElementById("previewImage");
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
        };
        reader.readAsDataURL(file);
    } else {
        previewImage.style.display = "none";
    }
});
