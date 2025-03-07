// Espera a que el documento HTML esté completamente cargado antes de ejecutar el script
document.addEventListener("DOMContentLoaded", function () {

    // Obtiene el botón para añadir ingredientes
    const addIngredientBtn = document.getElementById("addIngredient");

    // Obtiene el botón para cerrar la lista de ingredientes
    const closeIngredientListBtn = document.getElementById("closeIngredientList");

    // Obtiene el contenedor donde se mostrarán los ingredientes
    const ingredientContainer = document.getElementById("ingredientContainer");

    // Variable de control para saber si los ingredientes ya han sido cargados
    let ingredientesVisibles = false;

    // Evento al hacer clic en el botón de "Añadir Ingrediente"
    addIngredientBtn.addEventListener("click", function ()
    {
        if (!ingredientesVisibles) {
            
            // Hace una petición a un archivo PHP que devuelve la lista de ingredientes en formato JSON
            fetch("includes/entidades/ingrediente/getIngredientes.php")
                .then(response => response.json()) // Convierte la respuesta a JSON
                .then(data => {

                    mostrarIngredientes(data); // Llama a la función que muestra los ingredientes en pantalla

                    ingredientesVisibles = true; // Marca que los ingredientes ya fueron cargados

                    ingredientContainer.style.display = "block"; // Muestra el contenedor de ingredientes
                })
                .catch(error => console.error("Error cargando los ingredientes:", error)); // Muestra error en caso de fallo en la carga

        } else {
            // Si los ingredientes ya han sido cargados previamente, solo los muestra
            ingredientContainer.style.display = "block";
        }
    });

    // Evento al hacer clic en el botón de cerrar la lista de ingredientes
    closeIngredientListBtn.addEventListener("click", function () 
    {
        if (ingredientesVisibles) {

            // Alterna la visibilidad del contenedor de ingredientes
            ingredientContainer.style.display = ingredientContainer.style.display === "none" ? "block" : "none";
        }
    });

    // Función que recibe un array de ingredientes y los muestra en el contenedor
    function mostrarIngredientes(ingredientes)
    {

        // Limpia el contenedor antes de agregar los nuevos ingredientes
        ingredientContainer.innerHTML = "";

        // Asegura que el contenedor sea visible
        ingredientContainer.style.display = "block";

        // Recorre la lista de ingredientes recibidos
        ingredientes.forEach(ingrediente => {

            // Crea un div para cada ingrediente
            const div = document.createElement("div");

            div.classList.add("ingrediente-item"); // Agrega una clase para estilos

            // Inserta el HTML dentro del div con un checkbox, nombre, input de cantidad y selector de magnitud
            div.innerHTML = `
                <input type="checkbox" class="ingrediente-check" data-id="${ingrediente.id}" data-nombre="${ingrediente.nombre}">
                <label>${ingrediente.nombre}</label>
                <input type="number" class="ingrediente-cantidad" name="ingredientes[${ingrediente.id}][cantidad]" placeholder="Cantidad" min="0" step="0.1" disabled>
                <select class="ingrediente-magnitud" name="ingredientes[${ingrediente.id}][magnitud]" disabled>
                    <option value="g">Gramos (G)</option>
                    <option value="kg">Kilos (Kg)</option>
                    <option value="l">Litros (L)</option>
                    <option value="ml">Mililitros (ml)</option>
                    <option value="cucharadas">Cucharadas</option>
                    <option value="unidad">Unidad</option>
                </select>
            `;

            // Obtiene referencias a los elementos dentro del div
            const checkbox = div.querySelector(".ingrediente-check");

            const cantidadInput = div.querySelector(".ingrediente-cantidad");

            const magnitudSelect = div.querySelector(".ingrediente-magnitud");

            // Evento para habilitar los inputs de cantidad y magnitud cuando se marca el checkbox
            checkbox.addEventListener("change", function () {

                if (checkbox.checked) {

                    cantidadInput.disabled = false; // Habilita el input de cantidad

                    magnitudSelect.disabled = false; // Habilita el selector de magnitud
                } else {

                    cantidadInput.disabled = true; // Deshabilita el input de cantidad

                    cantidadInput.value = ""; // Borra el valor ingresado

                    magnitudSelect.disabled = true; // Deshabilita el selector de magnitud
                }
            });

            // Agrega el ingrediente al contenedor
            ingredientContainer.appendChild(div);
        });
    }
});
