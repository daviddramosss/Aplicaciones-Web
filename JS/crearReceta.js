document.addEventListener("DOMContentLoaded", function() {
    let stepCounter = 1; // Comienza en 1 porque ya hay un paso inicial
    const maxEtiquetas = 3; // Número máximo de etiquetas permitidas

    // Evento para añadir un nuevo paso en la receta
    document.getElementById("addStep").addEventListener("click", function() {

        stepCounter++; // Incrementa el contador de pasos

        let stepsContainer = document.getElementById("stepsContainer");

        // Crea un nuevo elemento de paso con un textarea
        let newStep = document.createElement("p");

        newStep.classList.add("step-item"); // Añade una clase para estilos

        newStep.innerHTML = `<label>Paso ${stepCounter}:</label> <textarea name="steps[]" required></textarea>`;

        stepsContainer.appendChild(newStep); // Agrega el nuevo paso al contenedor
    });

    // Evento para eliminar el último paso agregado
    document.getElementById("removeStep").addEventListener("click", function() {

        let stepsContainer = document.getElementById("stepsContainer");
        let steps = stepsContainer.getElementsByClassName("step-item");

        if (steps.length > 0) {

            stepsContainer.removeChild(steps[steps.length - 1]); // Elimina el último paso

            stepCounter--; // Decrementa el contador de pasos
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

    // Evento para actualizar el ingreso estimado cuando el usuario cambia el precio
    precioInput.addEventListener("input", actualizarIngresoEstimado);

    // Manejo de etiquetas dinámicas con un máximo de 3 etiquetas
    const etiquetaInput = document.getElementById("etiquetaInput");
    const btnAgregarEtiqueta = document.getElementById("addTag");
    const contenedorEtiquetas = document.getElementById("tagsContainer");

    btnAgregarEtiqueta.addEventListener("click", function () {

        const etiquetasActuales = contenedorEtiquetas.getElementsByClassName("etiqueta").length;

        if (etiquetasActuales >= maxEtiquetas) {
            alert("Solo puedes añadir hasta 3 etiquetas."); // Evita agregar más de 3 etiquetas
            return;
        }

        const etiquetaTexto = etiquetaInput.value.trim(); // Elimina espacios innecesarios

        if (etiquetaTexto !== "") {
            agregarEtiqueta(etiquetaTexto); // Llama a la función para agregar la etiqueta
            etiquetaInput.value = ""; // Limpia el campo de entrada
        }
    });

    // Función para agregar una etiqueta al contenedor
    function agregarEtiqueta(texto) {

        const etiqueta = document.createElement("div");

        etiqueta.classList.add("etiqueta"); // Añade la clase para estilos
        etiqueta.textContent = texto; // Establece el texto de la etiqueta

        // Crea un input oculto para enviar las etiquetas al formulario
        const inputOculto = document.createElement("input");

        inputOculto.type = "hidden";
        inputOculto.name = "etiquetas[]"; // Se envía como un array en el formulario
        inputOculto.value = texto;

        // Botón para eliminar la etiqueta
        const btnEliminar = document.createElement("button");
        btnEliminar.textContent = "✖";
        btnEliminar.classList.add("btn-eliminar");

        // Evento para eliminar la etiqueta y su input oculto
        btnEliminar.addEventListener("click", function () {
            etiqueta.remove();
            inputOculto.remove();
        });

        // Agrega los elementos creados a la etiqueta
        etiqueta.appendChild(btnEliminar);
        etiqueta.appendChild(inputOculto);        
        contenedorEtiquetas.appendChild(etiqueta); // Agrega la etiqueta al contenedor
    }

});
