document.addEventListener("DOMContentLoaded", function () {
    const addIngredientBtn = document.getElementById("addIngredient");
    const ingredientContainer = document.getElementById("ingredientContainer");

    addIngredientBtn.addEventListener("click", function () {
        fetch("/MarketChef/includes/ingrediente/getIngredientes.php") // Llamamos al archivo PHP que devuelve la lista de ingredientes
            .then(response => response.json())
            .then(data => {
                mostrarIngredientes(data);
            })
            .catch(error => console.error("Error cargando los ingredientes:", error));
    });

    function mostrarIngredientes(ingredientes) {
        // Limpiamos el contenedor antes de agregar nuevos ingredientes
        ingredientContainer.innerHTML = "";

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
