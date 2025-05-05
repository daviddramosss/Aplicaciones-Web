document.addEventListener("DOMContentLoaded", function () {
    //obtiene los elementos del formulario para procesarlos 
    const inputIngrediente = document.getElementById("nuevoIngrediente");
    const btnAgregar = document.getElementById("agregarIngrediente");
    const listaIngredientes = document.querySelector(".ingredientes-lista");

    //se activa cuando se selecciona de añadir ingredientes (+)
    btnAgregar.addEventListener("click", function () {

        const valor = inputIngrediente.value.trim();

        if (valor) { //verificar que no este vacio

            //Crea un nuevo elemento div para representar el nuevo ingrediente
            const nuevoElemento = document.createElement("div");

            nuevoElemento.classList.add("ingrediente");
            nuevoElemento.textContent = valor; //le asigna el valor introducido

            listaIngredientes.appendChild(nuevoElemento);//añade el nuevo ingrediente a la lista de ingredientes
            
            inputIngrediente.value = "";
        }
    });

    //Permite que al presionar enter se simule que se ha seleccionado el boton y se añada el nuevo ingrediente
    inputIngrediente.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            btnAgregar.click();
        }
    });
});