function confirmarEliminacion(id) {
    const respuesta = confirm("Estás a punto de eliminar un elemento. ¿Estás seguro?");
    if (respuesta) {
        document.getElementById('form_eliminar_' + id).submit();
    }
}
