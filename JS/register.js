
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