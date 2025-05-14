document.addEventListener("DOMContentLoaded", () => {
    const boton = document.querySelector('button[name="cambiarPassword"]');
    const contenedor = document.getElementById("passwords-container");
  
    let camposVisibles = false;
  
    boton.addEventListener("click", () => {
        if (!camposVisibles) {

            const div0 = document.createElement("div");
            div0.className = "input-container";
            const input0 = document.createElement("input");
            input0.type = "password";
            input0.name = "antiguaPassword";
            input0.placeholder = "CONTRASEÑA ACTUAL";
            div0.appendChild(input0);

            const div1 = document.createElement("div");
            div1.className = "input-container";
            const input1 = document.createElement("input");
            input1.type = "password";
            input1.name = "password";
            input1.placeholder = "CONTRASEÑA";
            div1.appendChild(input1);
        
            // Crear segundo contenedor con input
            const div2 = document.createElement("div");
            div2.className = "input-container";
            const input2 = document.createElement("input");
            input2.type = "password";
            input2.name = "rePassword";
            input2.placeholder = "CONFIRMAR CONTRASEÑA";
            div2.appendChild(input2);
        
            // Añadir al contenedor
            contenedor.appendChild(div0);
            contenedor.appendChild(div1);
            contenedor.appendChild(div2);
        
            camposVisibles = true;
        } 
        else {
            // Eliminar inputs
            contenedor.innerHTML = "";
            camposVisibles = false;
        }
    });
  });

//Evento para mostrar imagen cargada
document.getElementById("imagenUsuario").addEventListener("change", function (event) {
    const previewImage = document.getElementById("previewImage");
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
        };
        reader.readAsDataURL(file);
    } else {
        previewImage.style.display = "none";
    }
});