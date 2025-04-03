document.addEventListener("DOMContentLoaded", function () {
    const tagsContainer = document.getElementById("tagsContainer");

    // Crear el campo de búsqueda
    const searchInput = document.createElement("input");
    searchInput.type = "text";
    searchInput.placeholder = "Buscar etiquetas...";
    searchInput.id = "tagSearch";
    tagsContainer.parentNode.insertBefore(searchInput, tagsContainer);

    const selectedTagsContainer = document.createElement("div");
    selectedTagsContainer.id = "selectedTagsContainer";
    tagsContainer.appendChild(selectedTagsContainer);

    let etiquetasData = [];
    let selectedTags = [];

    // Cargar etiquetas automáticamente
    fetch("includes/endpoints/getEtiquetas.php")
        .then(response => response.json())
        .then(data => {
            etiquetasData = data;
            mostrarEtiquetas(data);
        })
        .catch(error => console.error("Error cargando las etiquetas:", error));

    function mostrarEtiquetas(etiquetas) {
        tagsContainer.innerHTML = "";
        tagsContainer.appendChild(selectedTagsContainer); // Mantener contenedor de seleccionadas

        if (etiquetas.length === 0) {
            tagsContainer.innerHTML += "<p>No hay etiquetas que coincidan con la búsqueda.</p>";
            return;
        }

        etiquetas.forEach(etiqueta => {
            let tagElement = document.createElement("span");
            tagElement.classList.add("tag");
            tagElement.textContent = etiqueta.nombre;
            tagElement.setAttribute("data-id", etiqueta.id);

            // Restaurar selección si la etiqueta ya estaba seleccionada
            if (selectedTags.includes(etiqueta.id)) {
                tagElement.classList.add("selected");
            }

            tagElement.addEventListener("click", function () {
                if (selectedTags.includes(etiqueta.id)) {
                    selectedTags = selectedTags.filter(id => id !== etiqueta.id);
                    tagElement.classList.remove("selected");
                } else {
                    if (selectedTags.length < 3) {
                        selectedTags.push(etiqueta.id);
                        tagElement.classList.add("selected");
                    }
                }
                actualizarCampoOculto();
            });

            tagsContainer.appendChild(tagElement);
        });
    }

    function actualizarCampoOculto() {
        let inputHidden = document.getElementById("etiquetasSeleccionadas");
        inputHidden.value = selectedTags.join(",");
    }

    // Evento de búsqueda dinámica
    searchInput.addEventListener("input", function () {
        const searchTerm = searchInput.value.toLowerCase();
        const filteredTags = etiquetasData.filter(tag => tag.nombre.toLowerCase().startsWith(searchTerm));
        mostrarEtiquetas(filteredTags);
    });

    // Rellena las etiquetas de la receta
    const observer = new MutationObserver(() => {
        let checkboxesEncontrados = 0;

        etiquetasReceta.forEach(etiqueta => {
            let tagElement = document.querySelector(`.tag[data-id="${etiqueta.id}"]`);

            if (tagElement) {
                tagElement.classList.add("selected");
                if (!selectedTags.includes(etiqueta.id)) {
                    selectedTags.push(etiqueta.id);
                }
                checkboxesEncontrados++;
            }
        });

        actualizarCampoOculto();

        // Si todas las etiquetas fueron marcadas, deja de observar
        if (checkboxesEncontrados === etiquetasReceta.length) {
            observer.disconnect();
        }
    });

    // Iniciar observación en el contenedor donde se insertan las etiquetas
    if (tagsContainer) {
        observer.observe(tagsContainer, { childList: true, subtree: true });
    }
});
