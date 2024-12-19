// Función para cargar las tablas dinámicamente desde el PHP
document.addEventListener("DOMContentLoaded", function() {
    const select = document.getElementById('opciones');
    
    fetch("vacante.php")
        .then(response => response.json())
        .then(tablas => {
            tablas.forEach(tabla => {
                const option = document.createElement("option");
                option.value = tabla;
                option.textContent = tabla.toUpperCase(); // Muestra el nombre en mayúsculas
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar las tablas:', error));
});

// Redirige a reclutador.html con el nombre de la tabla seleccionada
function redirigirFormulario() {
    var select = document.getElementById('opciones');
    var selectedOption = select.value;

    if (selectedOption) {
        window.location.href = "reclutador.html?tabla=" + encodeURIComponent(selectedOption);
    }
}
// Función para obtener una cookie por su nombre
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

const images = ["img/DEIT.jpg", "img/image1.jpeg", "img/image2.jpeg"];
let currentIndex = 0;

function changeImage() {
    const imgElement = document.getElementById("animated-img");
    currentIndex = (currentIndex + 1) % images.length;
    imgElement.src = images[currentIndex];
}

window.onload = function() {
    setInterval(changeImage, 3000); 

    const userInfo = document.getElementById('user-info');
    const user = getCookie('usuario');

    if (user) {
        userInfo.textContent = `Bienvenido, ${user}`;
    } else {
        window.location.href = 'iniciosesion.html';
    }
};

// Función para cerrar sesión (borrar cookies y redirigir al login)
function logout() {
    document.cookie = 'usuario=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    document.cookie = 'rol=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    window.location.href = 'logout.php';  // Verifica que este archivo exista
}
