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
                <input type="checkbox" class="ingrediente-check" data-nombre="${ingrediente.nombre}">
                <label>${ingrediente.nombre}</label>
                <input type="number" class="ingrediente-cantidad" placeholder="Cantidad" min="0" step="0.1" disabled>
                <select class="ingrediente-magnitud" disabled>
                    <option value="gramos">Gramos</option>
                    <option value="mililitros">Mililitros</option>
                    <option value="unidades">Unidades</option>
                </select>
            `;

            ingredientContainer.appendChild(div);
        });

        // Habilitar cantidad y magnitud solo si el checkbox está marcado
        document.querySelectorAll(".ingrediente-check").forEach(checkbox => {
            checkbox.addEventListener("change", function () {
                const parent = this.parentElement;
                const cantidadInput = parent.querySelector(".ingrediente-cantidad");
                const magnitudSelect = parent.querySelector(".ingrediente-magnitud");

                if (this.checked) {
                    cantidadInput.removeAttribute("disabled");
                    magnitudSelect.removeAttribute("disabled");
                } else {
                    cantidadInput.setAttribute("disabled", "true");
                    magnitudSelect.setAttribute("disabled", "true");
                }
            });
        });
    }
});
