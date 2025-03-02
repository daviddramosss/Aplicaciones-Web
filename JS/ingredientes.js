document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("addIngredient").addEventListener("click", function () {
        fetch("ingredienteAppService.php?action=obtenerIngredientes")
            .then(response => response.json())
            .then(data => {
                let container = document.getElementById("ingredientList");
                container.innerHTML = ""; // Limpiamos antes de mostrar

                data.forEach(ingrediente => {
                    let div = document.createElement("div");
                    div.innerHTML = `
                        <input type="checkbox" name="ingredientes[]" value="${ingrediente.id}">
                        ${ingrediente.nombre}
                        <input type="number" name="cantidad_${ingrediente.id}" placeholder="Cantidad" min="0.1" step="0.1" required>
                        <select name="unidad_${ingrediente.id}">
                            <option value="g">g</option>
                            <option value="kg">kg</option>
                            <option value="ml">ml</option>
                            <option value="l">l</option>
                            <option value="u">Unidad</option>
                        </select>
                    `;
                    container.appendChild(div);
                });
            })
            .catch(error => console.error("Error obteniendo ingredientes:", error));
    });
});
