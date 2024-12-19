function guardarRegistro() {
    const vacante = document.getElementById("vacante").value;
    const nombre = document.getElementById("nombre").value;
    const edad = document.getElementById("edad").value;
    const telefono = document.getElementById("telefono").value;
    const ubicacion = document.getElementById("ubicacion").value;

    if (!vacante || !nombre || !edad || !telefono || !ubicacion) {
        alert('Por favor, llene todos los campos.');
        return;
    }

    const data = new FormData();
    data.append('vacante', vacante);
    data.append('nombre', nombre);
    data.append('edad', edad);
    data.append('telefono', telefono);
    data.append('ubicacion', ubicacion);

    fetch('ingreso.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json()) // Asegúrate de convertir la respuesta a JSON
    .then(result => {
        if (result.success) {
            alert(result.success);
        } else {
            alert(result.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al procesar la solicitud.');
    });
}
