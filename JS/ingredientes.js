document.addEventListener("DOMContentLoaded", function () {
    const ingredientContainer = document.getElementById("ingredientContainer");

    // Crear el campo de búsqueda
    const searchInput = document.createElement("input");
    searchInput.type = "text";
    searchInput.placeholder = "Buscar ingredientes...";
    searchInput.id = "ingredientSearch";
    ingredientContainer.parentNode.insertBefore(searchInput, ingredientContainer);

    let ingredientesData = [];

    // Cargar ingredientes automáticamente
    fetch("includes/endpoints/getIngredientes.php")
        .then(response => response.json())
        .then(data => {
            ingredientesData = data;
            mostrarIngredientes(data);
        })
        .catch(error => console.error("Error cargando los ingredientes:", error));

    function mostrarIngredientes(ingredientes) {
        ingredientContainer.innerHTML = "";
        ingredientContainer.style.display = "block";

        fetch("includes/endpoints/getMagnitudes.php")
            .then(response => response.json())
            .then(magnitudes => {
                if (ingredientes.length === 0) {
                    ingredientContainer.innerHTML = "<p>No hay ingredientes que coincidan con la búsqueda.</p>";
                    return;
                }

                ingredientes.forEach(ingrediente => {
                    const div = document.createElement("div");
                    div.classList.add("ingrediente-item");

                    const checkbox = document.createElement("input");
                    checkbox.type = "checkbox";
                    checkbox.classList.add("ingrediente-check");
                    checkbox.setAttribute("data-id", ingrediente.id);
                    checkbox.setAttribute("data-nombre", ingrediente.nombre);

                    const label = document.createElement("label");
                    label.textContent = ingrediente.nombre;

                    const cantidadInput = document.createElement("input");
                    cantidadInput.type = "number";
                    cantidadInput.classList.add("ingrediente-cantidad");
                    cantidadInput.name = `ingredientes[${ingrediente.id}][cantidad]`;
                    cantidadInput.placeholder = "Cantidad";
                    cantidadInput.min = "0";
                    cantidadInput.step = "0.1";
                    cantidadInput.disabled = true;

                    const magnitudSelect = document.createElement("select");
                    magnitudSelect.classList.add("ingrediente-magnitud");
                    magnitudSelect.name = `ingredientes[${ingrediente.id}][magnitud]`;
                    magnitudSelect.disabled = true;

                    magnitudes.forEach(mag => {
                        const option = document.createElement("option");
                        option.value = mag.id;
                        option.textContent = mag.nombre;
                        magnitudSelect.appendChild(option);
                    });

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

                    div.appendChild(checkbox);
                    div.appendChild(label);
                    div.appendChild(cantidadInput);
                    div.appendChild(magnitudSelect);
                    ingredientContainer.appendChild(div);

                    
                });
            })
            .catch(error => console.error("Error cargando las magnitudes:", error));
    }

    // Evento de búsqueda dinámica
    searchInput.addEventListener("input", function () {
        const searchTerm = searchInput.value.toLowerCase();
        const filteredIngredients = ingredientesData.filter(ing => ing.nombre.toLowerCase().startsWith(searchTerm));
        mostrarIngredientes(filteredIngredients);
    });

    //Rellena los ingredientes de la receta
    const observer = new MutationObserver(() => {
        let checkboxesEncontrados = 0;

        ingredientesReceta.forEach(ingrediente => {
            let checkbox = document.querySelector(`input[data-id="${ingrediente.id}"]`);

            if (checkbox) {
                checkbox.checked = true;

                let inputCantidad = checkbox.closest("div").querySelector('.ingrediente-cantidad');
                if (inputCantidad) {
                    inputCantidad.value = ingrediente.cantidad;
                    inputCantidad.disabled = false;  // Asegurar que es editable
                }

                let selectMagnitud = checkbox.closest("div").querySelector('.ingrediente-magnitud');
                if (selectMagnitud) {
                    let option = selectMagnitud.querySelector(`option[value="${ingrediente.id_magnitud}"]`);
                    if (option) {
                        selectMagnitud.value = ingrediente.id_magnitud;
                        selectMagnitud.disabled = false;  // Asegurar que siga siendo editable
                    }
                }

                checkboxesEncontrados++;
            }
        });

        // Si todos los ingredientes fueron marcados, deja de observar
        if (checkboxesEncontrados === ingredientesReceta.length) {
            observer.disconnect();
        }
    });

    // Iniciar observación en el contenedor donde se insertan los ingredientes
    if (ingredientContainer) {
        observer.observe(ingredientContainer, { childList: true, subtree: true });
    }
});