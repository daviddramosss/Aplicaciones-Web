//Esta funcion notifica al usuario cuando se va a enviar el formulario
//Al hacer submit en el formulario, se activa esta funcion mostrando dicho mensaje por pantalla
document.addEventListener("DOMContentLoaded", function () {
    
    document.getElementById("contactoFormulario").addEventListener("submit", function (event) {
        
        // Evitamos que la página se recargue sola, mostramos el mensaje y redirigimos al index
        event.preventDefault()
        alert("Formulario enviado. Nos pondremos en contacto contigo.");
        window.location.href = "index.php";
    });

   
});