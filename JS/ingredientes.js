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

        // Obtener magnitudes antes de mostrar los ingredientes
        fetch("includes/entidades/magnitudes/getMagnitudes.php")
        .then(response => response.json())
        .then(magnitudes => {
            ingredientes.forEach(ingrediente => {
                
            const div = document.createElement("div");
            div.classList.add("ingrediente-item");

            // Crear los elementos y aplicar estilos CSS
            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.classList.add("ingrediente-check"); // Aplica una clase al checkbox
            checkbox.setAttribute("data-id", ingrediente.id);
            checkbox.setAttribute("data-nombre", ingrediente.nombre);

            const label = document.createElement("label");
            label.textContent = ingrediente.nombre;

            const cantidadInput = document.createElement("input");
            cantidadInput.type = "number";
            cantidadInput.classList.add("ingrediente-cantidad"); // Aplica una clase al input de cantidad
            cantidadInput.name = `ingredientes[${ingrediente.id}][cantidad]`;
            cantidadInput.placeholder = "Cantidad";
            cantidadInput.min = "0";
            cantidadInput.step = "0.1";
            cantidadInput.disabled = true;

            const magnitudSelect = document.createElement("select");
            magnitudSelect.classList.add("ingrediente-magnitud"); // Aplica una clase al select
            magnitudSelect.name = `ingredientes[${ingrediente.id}][magnitud]`;
            magnitudSelect.disabled = true;

            // Agregar opciones al select
            magnitudes.forEach(mag => {
                const option = document.createElement("option");
                option.value = mag.nombre;
                option.textContent = mag.nombre;
                magnitudSelect.appendChild(option);
            });

            // Evento para habilitar/deshabilitar los campos
            checkbox.addEventListener("change", function () {
                if (checkbox.checked) {
                    cantidadInput.disabled = false;
                    magnitudSelect.disabled = false;
                } else {
                    cantidadInput.disabled = true;
                    cantidadInput.value = "";
                    magnitudSelect.disabled = true;
                }
            });

            // Agregar los elementos al contenedor principal
            div.appendChild(checkbox);
            div.appendChild(label);
            div.appendChild(cantidadInput);
            div.appendChild(magnitudSelect);

            ingredientContainer.appendChild(div);

            });
        })
        .catch(error => console.error("Error cargando las magnitudes:", error));
}
});