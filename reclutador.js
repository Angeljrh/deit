let registrosCargados = localStorage.getItem('registrosCargados') ? parseInt(localStorage.getItem('registrosCargados')) : 0;
let registrosGuardados = 0;

function guardarRegistro(id, tabla) {
    const fila = document.getElementById(`fila-${id}`);
    const comentario = fila.querySelector('textarea[name="comentario"]').value;
    const estatus = fila.querySelector('select[name="estatus"]').value;

    if (!comentario || !estatus) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, completa el comentario y selecciona un estatus.'
        });
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "reclutador.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status === 200) {
            Swal.fire({
                icon: 'success',
                title: 'Registro Guardado',
                text: xhr.responseText
            });
            registrosGuardados++;

            if (registrosGuardados === 5) {
                document.getElementById("cargar-mas-btn").disabled = false;
                registrosGuardados = 0;
            }
            fila.remove(); 
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al guardar el registro'
            });
        }
    };

    const params = `id=${id}&comentario=${encodeURIComponent(comentario)}&estatus=${encodeURIComponent(estatus)}&tabla=${tabla}`;
    xhr.send(params);
}

function cargarMasRegistros() {
    registrosCargados += 5;
    localStorage.setItem('registrosCargados', registrosCargados);

    document.getElementById("cargar-mas-btn").disabled = true;
    registrosGuardados = 0;

    const tablaSeleccionada = obtenerParametroTabla();
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `reclutador.php?tabla=${tablaSeleccionada}&offset=${registrosCargados}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("tabla-contenido").innerHTML += this.responseText;
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar más registros'
            });
        }
    };
    xhr.send();
}

window.onload = function() {
    const userInfo = document.getElementById('user-info');
    const user = getCookie('usuario');
    if (user) {
        userInfo.textContent = `Bienvenido, ${user}`;
    } else {
        window.location.href = 'index.html';
    }
    cargarTabla();
};

function logout() {
    document.cookie = 'usuario=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    document.cookie = 'rol=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    window.location.href = 'logout.php';
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const nombreVacante = urlParams.get("tabla");
    document.getElementById("titulo-vacante").textContent = nombreVacante || "Vacante";
});

function obtenerParametroTabla() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get("tabla");
}

function cargarTabla() {
    const tablaSeleccionada = obtenerParametroTabla();
    if (tablaSeleccionada) {
        document.getElementById('titulo-vacante').textContent = tablaSeleccionada.toUpperCase();

        const xhr = new XMLHttpRequest();
        xhr.open("GET", `reclutador.php?tabla=${tablaSeleccionada}&offset=${registrosCargados}`, true);
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('tabla-contenido').innerHTML = this.responseText;
            } else {
                document.getElementById('tabla-contenido').innerHTML = 'Error al cargar la tabla';
            }
        };
        xhr.send();
    } else {
        document.getElementById('tabla-contenido').innerHTML = 'No se ha seleccionado ninguna tabla';
    }
}
