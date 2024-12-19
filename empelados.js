document.addEventListener('DOMContentLoaded', function () {
    cargarReclutadores();
    cargarTablas();
});

async function cargarReclutadores() {
    try {
        const response = await fetch('empleados.php?action=getReclutadores');
        const reclutadores = await response.json();
        const select = document.getElementById('reclutador');
        select.innerHTML = reclutadores.map(reclutador => `<option value="${reclutador.usuario}">${reclutador.usuario}</option>`).join('');
    } catch (error) {
        console.error('Error cargando reclutadores:', error);
    }
}

async function cargarTablas() {
    try {
        const response = await fetch('empleados.php?action=getTablas');
        const tablas = await response.json();
        const select = document.getElementById('vacante');
        select.innerHTML = tablas.map(tabla => `<option value="${tabla}">${tabla}</option>`).join('');
    } catch (error) {
        console.error('Error cargando tablas:', error);
    }
}

document.getElementById('vacante').addEventListener('change', async function () {
    const vacante = this.value;
    try {
        const response = await fetch(`empleados.php?action=getFechas&tabla=${vacante}`);
        const fechas = await response.json();
        const select = document.getElementById('fecha');
        select.innerHTML = fechas.map(fecha => `<option value="${fecha}">${fecha}</option>`).join('');
    } catch (error) {
        console.error('Error cargando fechas:', error);
    }
});

async function enviarRegistros() {
    const reclutador = document.getElementById('reclutador').value;
    const vacante = document.getElementById('vacante').value;
    const fecha = document.getElementById('fecha').value;

    try {
        const response = await fetch('empleados.php?action=enviarRegistros', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ reclutador, vacante, fecha })
        });
        const result = await response.json();
        if (result.success) {
            alert('Registros actualizados con éxito.');
        } else {
            alert('Error al actualizar registros.');
        }
    } catch (error) {
        console.error('Error enviando registros:', error);
    }
}
