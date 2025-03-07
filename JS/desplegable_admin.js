document.addEventListener("DOMContentLoaded", function () {

    const usuarioIcono = document.querySelector(".admin_desplegable_cabecera");
    const menuUsuario = document.querySelector(".menu_admin");

    usuarioIcono.addEventListener("click", function (event) {

        event.stopPropagation(); // Evita que el click se propague
        menuUsuario.style.display = (menuUsuario.style.display === "flex") ? "none" : "flex";
    });

    // Ocultar el menú si se hace click fuera de él
    document.addEventListener("click", function (event) {
        
        if (!usuarioIcono.contains(event.target) && !menuUsuario.contains(event.target)) {
            menuUsuario.style.display = "none";
        }
    });
});