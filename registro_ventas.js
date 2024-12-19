document.addEventListener("DOMContentLoaded", () => {
    const contactButton = document.getElementById('contact-button');
    const backButton = document.getElementById('back-button');
    const videoSection = document.getElementById('video-section');
    const formSection = document.getElementById('contact-form');
    const form = document.getElementById("registroForm");

    // Función para desplazarse al formulario
window.scrollToForm = () => {
    formSection.scrollIntoView({ behavior: "smooth" });
    contactButton.style.display = "none"; // Oculta el botón de "Continuar"
    backButton.style.display = "block";   // Muestra el botón de "Regresar"
};


    // Función para regresar al video e imágenes
    window.scrollToTop = () => {
        const mainContainer = document.getElementById("main-container");
        mainContainer.scrollIntoView({ behavior: "smooth" });
        document.getElementById("contact-button").style.display = "flex"; // Vuelve a mostrar el botón "Continuar"
        document.getElementById("back-button").style.display = "none";    // Oculta el botón "Regresar"
    };
    
    

    // Alternar audio del video
    const video = document.getElementById('video');
    const audioToggle = document.getElementById('audioToggle');
    audioToggle.addEventListener('click', () => {
        if (video.muted) {
            video.muted = false;
            audioToggle.textContent = '🔇';
        } else {
            video.muted = true;
            audioToggle.textContent = '🔊';
        }
    });

       // Funcionalidad del formulario
       form.addEventListener("submit", (e) => {
        e.preventDefault();

        // Crear un objeto FormData con los datos del formulario
        const formData = new FormData(form);

        // Configurar la solicitud AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "registro_ventas.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                swal({
                    title: "Registro exitoso.",
                    text: "Debes estar pendiente, nos estaremos comunicando contigo.",
                    type: "success"
                }, function () {
                    form.reset(); // Reinicia el formulario
                    window.location.href = "https://www.talentodeit.com/";
                });
            } else {
                alert("Error al enviar los datos. Intenta de nuevo.");
            }
        };

        // Enviar los datos del formulario
        xhr.send(formData);
    });
});