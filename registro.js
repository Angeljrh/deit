    document.getElementById('formularioRegistro').addEventListener('submit', function(event) {
    event.preventDefault();

    // Obtener el valor de la tabla desde la URL
    var urlParams = new URLSearchParams(window.location.search);
    var tablaSeleccionada = urlParams.get('tabla');

    if (!tablaSeleccionada) {
        alert("No se seleccionó ninguna tabla.");
        return;
    }

    // Obtener los valores del formulario
    var nombres = document.getElementById('nombres').value;
    var edad = document.getElementById('edad').value;
    var ubicacion = document.getElementById('ubicacion').value;
    var telefono = document.getElementById('telefono').value;

    // Validar que los campos no estén vacíos antes de enviar
    if (!nombres || !edad || !ubicacion || !telefono) {
        alert("Todos los campos son obligatorios.");
        return;
    }

    // Crear el objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'procesar_registro.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Crear la cadena de parámetros
    var params = 'tabla=' + encodeURIComponent(tablaSeleccionada) 
                 + '&nombres=' + encodeURIComponent(nombres)
                 + '&edad=' + encodeURIComponent(edad)
                 + '&ubicacion=' + encodeURIComponent(ubicacion)
                 + '&telefono=' + encodeURIComponent(telefono);

    // Enviar la solicitud
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
        }
    };

    xhr.send(params);
});
