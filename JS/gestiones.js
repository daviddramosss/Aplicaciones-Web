function buscarIngredientes() {
    const termino = document.getElementById('buscar').value;
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'buscarIngredientes.php?termino=' + encodeURIComponent(termino), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const ingredientes = JSON.parse(xhr.responseText);
            const tabla = document.getElementById('tabla_ingredientes');
            let contenidoTabla = `
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            `;
            ingredientes.forEach(ingrediente => {
                contenidoTabla += `
                    <tr>
                        <td>${ingrediente.id}</td>
                        <td>${ingrediente.nombre}</td>
                        <td>
                            <form action='gestionarIngredientes.php' method='POST' style='display:inline;' id='form_eliminar_${ingrediente.id}'>
                                <input type='hidden' name='eliminar_id' value='${ingrediente.id}'>
                                <button type='button' onclick='confirmarEliminacion(${ingrediente.id})'>🗑️ Eliminar</button>
                            </form>
                        </td>
                    </tr>
                `;
            });
            tabla.innerHTML = contenidoTabla;
        }
    };
    xhr.send();

    function confirmarEliminacion(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este ingrediente?")) {
            document.getElementById('form_eliminar_' + id).submit();
        }
    }
    
    
}
