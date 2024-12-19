function guardarRegistro(id) {
    const fila = document.getElementById(`fila-${id}`);
    const observaciones = fila.querySelector('textarea[name="observaciones"]').value;
    const estatus = fila.querySelector('select[name="estatus"]').value;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "ventas.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status === 200) {
            alert("Registro guardado correctamente");
        } else {
            alert("Error al guardar el registro");
        }
    };

    const params = `id=${id}&observaciones=${encodeURIComponent(observaciones)}&estatus=${encodeURIComponent(estatus)}`;
    xhr.send(params);
}

function cargarTabla() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "ventas.php", true);

    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('tabla-contenido').innerHTML = this.responseText;
        } else {
            document.getElementById('tabla-contenido').innerHTML = 'Error al cargar la tabla';
        }
    };

    xhr.send();
}

document.addEventListener('DOMContentLoaded', function() {
    cargarTabla();
});
