document.addEventListener("DOMContentLoaded", function() {
    let stepCounter = 1; // Comienza en 1 porque ya hay un paso inicial
    const maxEtiquetas = 3;

    document.getElementById("addStep").addEventListener("click", function() {
        stepCounter++; // Incrementa el contador
        let stepsContainer = document.getElementById("stepsContainer");

        // Crea un nuevo paso con su número
        let newStep = document.createElement("p");
        newStep.classList.add("step-item"); // Añade una clase para identificar los pasos
        newStep.innerHTML = `<label>Paso ${stepCounter}:</label> <textarea name="steps[]" required></textarea>`;

        stepsContainer.appendChild(newStep); // Añade el nuevo paso al contenedor
    });

    document.getElementById("removeStep").addEventListener("click", function() {
        let stepsContainer = document.getElementById("stepsContainer");
        let steps = stepsContainer.getElementsByClassName("step-item");

        if (steps.length > 0) {
            stepsContainer.removeChild(steps[steps.length - 1]); // Eliminar el último paso
            stepCounter--; // Decrementa el contador
        }
    });

    // Referencias a los elementos del precio y del ingreso estimado
    let precioInput = document.querySelector('input[name="precio"]');
    let ingresoEstimadoSpan = document.getElementById("ingresoEstimado");

    // Función para actualizar el ingreso estimado
    function actualizarIngresoEstimado() {
        let precio = parseFloat(precioInput.value) || 0; // Obtener el precio y convertirlo a número
        let ingresoEstimado = precio * 0.85; // Aplicar el 15% de comisión (85% restante)
        ingresoEstimadoSpan.textContent = ingresoEstimado.toFixed(2); // Mostrar con 2 decimales
    }

    // Evento cuando el usuario introduce o modifica el precio
    precioInput.addEventListener("input", actualizarIngresoEstimado);

   // Agregar etiquetas dinámicamente (Máximo 3 etiquetas)
   const etiquetaInput = document.getElementById("etiquetaInput");
   const btnAgregarEtiqueta = document.getElementById("addTag");
   const contenedorEtiquetas = document.getElementById("tagsContainer");

   btnAgregarEtiqueta.addEventListener("click", function () {
       const etiquetasActuales = contenedorEtiquetas.getElementsByClassName("etiqueta").length;

       if (etiquetasActuales >= maxEtiquetas) {
           alert("Solo puedes añadir hasta 3 etiquetas.");
           return;
       }

       const etiquetaTexto = etiquetaInput.value.trim();

       if (etiquetaTexto !== "") {
           agregarEtiqueta(etiquetaTexto);
           etiquetaInput.value = ""; // Limpiar el campo de entrada
       }
   });

    function agregarEtiqueta(texto) {
        const etiqueta = document.createElement("div");
        etiqueta.classList.add("etiqueta");
        etiqueta.textContent = texto;

        const inputOculto = document.createElement("input");
        inputOculto.type = "hidden";
        inputOculto.name = "etiquetas[]"; // Importante para que llegue como array
        inputOculto.value = texto;

        const btnEliminar = document.createElement("button");
        btnEliminar.textContent = "✖";
        btnEliminar.classList.add("btn-eliminar");
        btnEliminar.addEventListener("click", function () {
            etiqueta.remove();
            inputOculto.remove();
        });

        etiqueta.appendChild(btnEliminar);
        etiqueta.appendChild(inputOculto);
        contenedorEtiquetas.appendChild(etiqueta);
    }

});
