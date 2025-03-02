document.addEventListener("DOMContentLoaded", function () {
    const addIngredientButton = document.getElementById("addIngredient");
    const ingredientList = document.getElementById("ingredientList");

    addIngredientButton.addEventListener("click", async function () {
        if (document.getElementById("ingredientDropdown")) return;

        // Crear el contenedor del desplegable
        const dropdown = document.createElement("div");
        dropdown.id = "ingredientDropdown";
        dropdown.innerHTML = `
            <table border="1">
                <thead>
                    <tr>
                        <th>Ingrediente</th>
                        <th>Cantidad</th>
                        <th>Magnitud</th>
                        <th>Seleccionar</th>
                    </tr>
                </thead>
                <tbody id="ingredientTableBody">
                    <tr><td colspan="4">Cargando ingredientes...</td></tr>
                </tbody>
            </table>
        `;
        ingredientList.appendChild(dropdown);

        try {
            // Hacer petición a PHP para obtener ingredientes
            const response = await fetch("obtenerIngredientes.php");
            const result = await response.json();

            if (result.success) {
                const tableBody = document.getElementById("ingredientTableBody");
                tableBody.innerHTML = ""; // Limpiar la tabla

                result.data.forEach(ingrediente => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${ingrediente.nombre}</td>
                        <td><input type="number" step="0.01" placeholder="Cantidad"></td>
                        <td>
                            <select>
                                <option value="g">g</option>
                                <option value="ml">ml</option>
                                <option value="unidad">unidad</option>
                            </select>
                        </td>
                        <td><button type="button" class="selectIngredient" data-id="${ingrediente.id}" data-nombre="${ingrediente.nombre}">✔</button></td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                document.getElementById("ingredientTableBody").innerHTML = "<tr><td colspan='4'>Error al cargar ingredientes</td></tr>";
            }
        } catch (error) {
            document.getElementById("ingredientTableBody").innerHTML = "<tr><td colspan='4'>Error de conexión</td></tr>";
        }
    });

    // Evento para manejar la selección del ingrediente
    ingredientList.addEventListener("click", function (event) {
        if (event.target.classList.contains("selectIngredient")) {
            const ingredienteNombre = event.target.getAttribute("data-nombre");
            alert(`Ingrediente seleccionado: ${ingredienteNombre}`);
        }
    });
});
