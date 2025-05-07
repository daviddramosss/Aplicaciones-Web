document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.carrito-eliminar-boton').forEach(button => {
        button.addEventListener('click', async () => {
            const recetaId = button.dataset.id;

            const formData = new FormData();
            formData.append('recetaId', recetaId);

            const response = await fetch('includes/endpoints/eliminarCarrito.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                const item = document.querySelector(`.carrito-item[data-id="${recetaId}"]`);
                if (item) {
                    item.remove();
                    actualizarTotal();
                }

                // Si el carrito queda vacío, mostrar mensaje
                if (document.querySelectorAll('.carrito-item').length === 0) {
                    document.querySelector('#carrito-container').innerHTML = '<p>No hay recetas en el carrito.</p>';
                }
            }
        });
    });
});

function actualizarTotal() {
    let total = 0;
    document.querySelectorAll('.carrito-item').forEach(item => {
        const precio = parseFloat(item.dataset.precio);
        total += precio;
    });

    const totalElem = document.querySelector('h2');
    if (totalElem) {
        totalElem.textContent = 'Total: ' + total.toFixed(2) + ' €';
    }

    // Actualizar también el campo oculto del formulario de pago
    const input = document.querySelector('input[name="importeTotal"]');
    if (input) {
        input.value = Math.round(total * 100); // en céntimos
    }
}
