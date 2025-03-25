document.addEventListener("DOMContentLoaded", function () {
    const addTagBtn = document.getElementById("addTag");
    const closeTagListBtn = document.getElementById("closeTagList");
    const tagsContainer = document.getElementById("tagsContainer");

    let etiquetasVisibles = false;
    let etiquetasSeleccionadas = [];

    // Evento al hacer clic en "Añadir Etiqueta"
    addTagBtn.addEventListener("click", function () {
        if (!etiquetasVisibles) {
            fetch("includes/entidades/etiquetas/getEtiquetas.php")
                .then(response => response.json())
                .then(data => {
                    mostrarEtiquetas(data);
                    etiquetasVisibles = true;
                    tagsContainer.style.display = "grid";
                })
                .catch(error => console.error("Error cargando las etiquetas:", error));
        } else {
            tagsContainer.style.display = "grid";
        }
    });

    // Evento al hacer clic en "Cerrar lista de etiquetas"
    closeTagListBtn.addEventListener("click", function () {
        if (etiquetasVisibles) {
            tagsContainer.style.display = "none";
        }
    });

    // Función para mostrar las etiquetas en una cuadrícula de 6 por fila
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
