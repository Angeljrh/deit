document.getElementById("nipForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    const nip = document.getElementById("nip").value;
    const validNip = "0122"; // Valor del NIP correcto
    const mensaje = document.getElementById("mensaje");

    // Validar usando objetos clave-valor
    const nipValidation = { nipIngresado: nip, nipCorrecto: validNip };

    if (nipValidation.nipIngresado === nipValidation.nipCorrecto) {
        mensaje.innerHTML = '<div class="alert alert-success">NIP correcto, puede proceder a ingresar datos.</div>';
        document.getElementById("insertForm").style.display = "block";
        document.getElementById("nipForm").style.display = "none"; // Ocultar el formulario de NIP
    } else {
        mensaje.innerHTML = '<div class="alert alert-danger">NIP incorrecto, intente nuevamente.</div>';
    }
});

document.getElementById("insertForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const tabla = document.getElementById("tablaSelect").value;
    const usuario = document.getElementById("usuario").value;
    const contrasena = document.getElementById("contrasena").value;
    const confirmarContrasena = document.getElementById("confirmarContrasena").value;
    const insertMensaje = document.getElementById("insertMensaje");

    // Validar que las contraseñas coincidan
    if (contrasena !== confirmarContrasena) {
        insertMensaje.innerHTML = '<div class="alert alert-danger">Las contraseñas no coinciden, intente nuevamente.</div>';
        return;
    }

    // Enviar datos con Ajax
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "insercion.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            insertMensaje.innerHTML = '<div class="alert alert-success">Usuario insertado correctamente.</div>';
            document.getElementById("insertForm").reset(); // Limpiar el formulario
        }
    };

    // Enviar los datos al servidor
    const data = `tabla=${tabla}&usuario=${usuario}&contrasena=${encodeURIComponent(contrasena)}`;
    xhr.send(data);
});
