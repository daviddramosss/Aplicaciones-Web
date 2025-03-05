document.addEventListener("DOMContentLoaded", function () {
    const addIngredientBtn = document.getElementById("addIngredient");
    const closeIngredientListBtn = document.getElementById("closeIngredientList");
    const ingredientContainer = document.getElementById("ingredientContainer");

    let ingredientesVisibles = false; // Controla la visibilidad del contenedor

    addIngredientBtn.addEventListener("click", function () {
        if (!ingredientesVisibles) {
            fetch("/MarketChef/includes/ingrediente/getIngredientes.php") // Llamamos al archivo PHP que devuelve la lista de ingredientes
                .then(response => response.json())
                .then(data => {
                    mostrarIngredientes(data);
                    ingredientesVisibles = true;
                    ingredientContainer.style.display = "block"; // Asegurar que se muestre
                })
                .catch(error => console.error("Error cargando los ingredientes:", error));
        } else {
            ingredientContainer.style.display = "block"; // Si ya están cargados, solo los muestra
        }
    });

    closeIngredientListBtn.addEventListener("click", function () {
        if (ingredientesVisibles) {
            ingredientContainer.style.display = ingredientContainer.style.display === "none" ? "block" : "none";
        }
    });

    function mostrarIngredientes(ingredientes) {
        // Limpiamos el contenedor antes de agregar nuevos ingredientes
        ingredientContainer.innerHTML = "";
        ingredientContainer.style.display = "block"; // Asegurar que el contenedor sea visible

        ingredientes.forEach(ingrediente => {
            const div = document.createElement("div");
            div.classList.add("ingrediente-item");

            div.innerHTML = `
                <input type="checkbox" class="ingrediente-check" data-id="${ingrediente.id}" data-nombre="${ingrediente.nombre}">
                <label>${ingrediente.nombre}</label>
                <input type="number" class="ingrediente-cantidad" name="ingredientes[${ingrediente.id}][cantidad]" placeholder="Cantidad" min="0" step="0.1" disabled>
                <select class="ingrediente-magnitud" name="ingredientes[${ingrediente.id}][magnitud]" disabled>
                    <option value="g">Gramos</option>
                    <option value="ml">Mililitros</option>
                    <option value="unidad">Unidad</option>
                </select>
            `;

            // Obtener referencias a los elementos
            const checkbox = div.querySelector(".ingrediente-check");
            const cantidadInput = div.querySelector(".ingrediente-cantidad");
            const magnitudSelect = div.querySelector(".ingrediente-magnitud");

            // Habilitar los inputs solo si el checkbox está marcado
            checkbox.addEventListener("change", function () {
                if (checkbox.checked) {
                    cantidadInput.disabled = false;
                    magnitudSelect.disabled = false;
                } else {
                    cantidadInput.disabled = true;
                    cantidadInput.value = ""; // Limpiar el valor si se deselecciona
                    magnitudSelect.disabled = true;
                }
            });

            ingredientContainer.appendChild(div);
        });
    }
});
