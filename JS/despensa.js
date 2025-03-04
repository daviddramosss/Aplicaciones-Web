document.addEventListener("DOMContentLoaded", function () {
    const inputIngrediente = document.getElementById("nuevoIngrediente");
    const btnAgregar = document.getElementById("agregarIngrediente");
    const listaIngredientes = document.querySelector(".ingredientes-lista");

    btnAgregar.addEventListener("click", function () {
        const valor = inputIngrediente.value.trim();
        if (valor) {
            const nuevoElemento = document.createElement("div");
            nuevoElemento.classList.add("ingrediente");
            nuevoElemento.textContent = valor;
            listaIngredientes.appendChild(nuevoElemento);
            inputIngrediente.value = "";
        }
    });

    inputIngrediente.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            btnAgregar.click();
        }
    });
});