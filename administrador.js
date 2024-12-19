document.addEventListener("DOMContentLoaded", function() {
    // Hacer una petición a administrador.php para obtener el nombre del usuario
    fetch('administrador.php')
        .then(response => response.json())
        .then(data => {
            if (data.username) {
                // Actualizar el nombre del usuario en el encabezado y en el saludo
                document.getElementById('username-header').textContent = `Bienvenido, ${data.username}!`;
                document.getElementById('username-greeting').textContent = `Hola, ${data.username}!`;
            } else {
                console.error(data.error);  // Mostrar el error en la consola si existe
            }
        })
        .catch(error => {
            console.error('Error al obtener el nombre del usuario:', error);
        });
});


