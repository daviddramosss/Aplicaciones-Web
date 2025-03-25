document.addEventListener("DOMContentLoaded", function () {
    const addTagBtn = document.getElementById("addTag");
    const closeTagListBtn = document.createElement("button");
    const tagsContainer = document.createElement("div");
    let etiquetasVisibles = false;
    let etiquetasSeleccionadas = [];

    // Configuración del contenedor de etiquetas
    tagsContainer.id = "tagsContainer";
    tagsContainer.style.display = "none";
    document.body.appendChild(tagsContainer);

    // Configuración del botón de cerrar lista
    closeTagListBtn.textContent = "Cerrar lista de etiquetas";
    closeTagListBtn.classList.add("btn-rojo");
    closeTagListBtn.style.display = "none";
    document.body.appendChild(closeTagListBtn);

    addTagBtn.addEventListener("click", function () {
        if (!etiquetasVisibles) {
            fetch("includes/entidades/etiquetas/getEtiquetas.php")
                .then(response => response.json())
                .then(data => {
                    mostrarEtiquetas(data);
                    etiquetasVisibles = true;
                    tagsContainer.style.display = "block";
                    closeTagListBtn.style.display = "inline-block";
                })
                .catch(error => console.error("Error cargando las etiquetas:", error));
        } else {
            tagsContainer.style.display = "block";
            closeTagListBtn.style.display = "inline-block";
        }
    });

    closeTagListBtn.addEventListener("click", function () {
        tagsContainer.style.display = "none";
        closeTagListBtn.style.display = "none";
    });

    function mostrarEtiquetas(etiquetas) {
        tagsContainer.innerHTML = "";

        etiquetas.forEach(etiqueta => {
            const div = document.createElement("div");
            div.classList.add("etiqueta-item");
            div.textContent = etiqueta.nombre;
            div.dataset.id = etiqueta.id;

            div.addEventListener("click", function () {
                if (div.classList.contains("seleccionada")) {
                    div.classList.remove("seleccionada");
                    etiquetasSeleccionadas = etiquetasSeleccionadas.filter(id => id !== etiqueta.id);
                } else {
                    if (etiquetasSeleccionadas.length < 3) {
                        div.classList.add("seleccionada");
                        etiquetasSeleccionadas.push(etiqueta.id);
                    } else {
                        alert("Solo puedes seleccionar hasta 3 etiquetas.");
                    }
                }
            });

            tagsContainer.appendChild(div);
        });
    }
});
