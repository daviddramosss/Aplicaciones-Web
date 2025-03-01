document.addEventListener("DOMContentLoaded", function () {
    const addIngredientButton = document.getElementById("addIngredient");
    const ingredientListDiv = document.getElementById("ingredientList");

    addIngredientButton.addEventListener("click", function () {
        agregarDesplegableIngredientes();
    });

    async function obtenerIngredientes() {
        try {
            const response = await fetch("../receta/ingredienteAppService.php");
            const data = await response.json();
            return data;
        } catch (error) {
            console.error("Error obteniendo los ingredientes:", error);
            return [];
        }
    }

    async function agregarDesplegableIngredientes() {
        const ingredientes = await obtenerIngredientes();
        if (ingredientes.length === 0) {
            alert("No se pudieron cargar los ingredientes.");
            return;
        }
        
        const div = document.createElement("div");
        div.classList.add("ingredient-item");
        
        const select = document.createElement("select");
        select.name = "ingredientes[]";
        select.required = true;
        
        ingredientes.forEach(ingrediente => {
            const option = document.createElement("option");
            option.value = ingrediente.id;
            option.textContent = ingrediente.nombre;
            select.appendChild(option);
        });
        
        const cantidadInput = document.createElement("input");
        cantidadInput.type = "number";
        cantidadInput.name = "cantidades[]";
        cantidadInput.step = "0.01";
        cantidadInput.min = "0";
        cantidadInput.placeholder = "Cantidad";
        cantidadInput.required = true;
        
        const unidadInput = document.createElement("input");
        unidadInput.type = "text";
        unidadInput.name = "unidades[]";
        unidadInput.placeholder = "Unidad (g, ml, etc.)";
        unidadInput.required = true;
        
        const removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.textContent = "Eliminar";
        removeButton.addEventListener("click", function () {
            div.remove();
        });
        
        div.appendChild(select);
        div.appendChild(cantidadInput);
        div.appendChild(unidadInput);
        div.appendChild(removeButton);
        ingredientListDiv.appendChild(div);
    }
});

