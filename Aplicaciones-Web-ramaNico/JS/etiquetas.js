document.addEventListener("DOMContentLoaded", function () {
    fetch("includes/entidades/etiquetas/getEtiquetas.php")
        .then(response => response.json())
        .then(data => {
            const tagsContainer = document.getElementById("tagsContainer");
            const selectedTagsContainer = document.createElement("div");
            selectedTagsContainer.id = "selectedTagsContainer";
            tagsContainer.appendChild(selectedTagsContainer);

            let selectedTags = [];

            data.forEach(etiqueta => {
                let tagElement = document.createElement("span");
                tagElement.classList.add("tag");
                tagElement.textContent = etiqueta.nombre;

                tagElement.addEventListener("click", function () {
                    if (selectedTags.includes(etiqueta.id)) {
                        selectedTags = selectedTags.filter(id => id !== etiqueta.id);
                        tagElement.classList.remove("selected");
                    } else {
                        if (selectedTags.length < 3) {
                            selectedTags.push(etiqueta.id);
                            tagElement.classList.add("selected");
                        } else {
                            alert("Solo puedes seleccionar hasta 3 etiquetas.");
                        }
                    }
                    actualizarCampoOculto();
                });

                tagsContainer.appendChild(tagElement);
            });

            function actualizarCampoOculto() {
                let inputHidden = document.getElementById("etiquetasSeleccionadas");
                inputHidden.value = selectedTags.join(",");
            }
        })
        .catch(error => console.error("Error cargando etiquetas:", error));
});
