document.addEventListener("DOMContentLoaded", function() {
    let stepCounter = 1; // Comienza en 1 porque ya hay un paso inicial

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

        stepsContainer.removeChild(steps[steps.length - 1]); // Eliminar el último paso
        stepCounter--; // Decrementa el contador

    });
});
