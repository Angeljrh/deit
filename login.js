document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const usuario = document.getElementById('usuario').value;
    const contrasena = document.getElementById('contrasena').value;
    
    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `usuario=${encodeURIComponent(usuario)}&contrasena=${encodeURIComponent(contrasena)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar SweetAlert de bienvenida
            Swal.fire({
                title: 'Bienvenido!',
                text: `Hola ${usuario}, has iniciado sesión con éxito.`,
                icon: 'success',
                confirmButtonText: 'Continuar'
            }).then(() => {
                // Redirigir a la página específica según el rol
                window.location.href = data.redirect;
            });
        } else {
            document.getElementById('mensaje').textContent = data.message;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('mensaje').textContent = 'Error en la conexión. Inténtalo más tarde.';
    });
});


