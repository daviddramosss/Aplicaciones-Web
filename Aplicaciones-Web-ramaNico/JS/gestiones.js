document.addEventListener("DOMContentLoaded", () => {
    console.log("gestiones.js cargado");

    window.confirmarEliminacion = function(id) {
        console.log(`Intentando eliminar ingrediente con id: ${id}`);
        const form = document.getElementById(`form_eliminar_${id}`);
        if (form && confirm("Estás a punto de eliminar un elemento. ¿Estás seguro?")) {
            form.submit();
        } else if (!form) {
            console.error(`Formulario con id form_eliminar_${id} no encontrado`);
        }
    };

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    window.buscarIngredientes = async function() {
        console.log("Buscando ingredientes...");
        const input = document.getElementById("busquedaIngrediente");
        const tbody = document.getElementById("cuerpoTabla");

        if (!input || !tbody) {
            console.error("Elementos busquedaIngrediente o cuerpoTabla no encontrados");
            return;
        }

        const q = encodeURIComponent(input.value.trim());
        try {
            const resp = await fetch(`buscarIngredientes.php?q=${q}`);
            if (!resp.ok) {
                throw new Error(`Error en la respuesta del servidor: ${resp.status}`);
            }
            const datos = await resp.json();
            console.log("Datos recibidos:", datos);

            if (!Array.isArray(datos)) {
                throw new Error("Formato de datos inválido");
            }

            tbody.innerHTML = datos.map(ing => {
                const id = Number(ing.id);
                const nombre = String(ing.nombre).replace(/</g, "&lt;").replace(/>/g, "&gt;");
                return `
                    <tr>
                        <td>${id}</td>
                        <td>${nombre}</td>
                        <td>
                            <form action="gestionarIngredientes.php" method="POST" id="form_eliminar_${id}" style="display:inline;">
                                <input type="hidden" name="eliminar_id" value="${id}">
                                <button type="button" onclick="confirmarEliminacion(${id})">🗑️ Eliminar</button>
                            </form>
                        </td>
                    </tr>`;
            }).join("");
        } catch (e) {
            console.error("Error en búsqueda AJAX:", e.message, e.stack);
            tbody.innerHTML = `<tr><td colspan="3">Error: ${e.message}. Inténtalo de nuevo.</td></tr>`;
        }
    };

    const inputBusqueda = document.getElementById("busquedaIngrediente");
    if (inputBusqueda) {
        const busquedaConDebounce = debounce(buscarIngredientes, 300);
        inputBusqueda.addEventListener("input", busquedaConDebounce);
    } else {
        console.error("Input con id busquedaIngrediente no encontrado");
    }
});