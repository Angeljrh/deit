document.addEventListener('DOMContentLoaded', cargarRegistros);

async function cargarRegistros() {
    const response = await fetch('reclutador.php');
    const registros = await response.json();
    const contenedor = document.getElementById('registros');
    
    registros.forEach(registro => {
        const div = document.createElement('div');
        div.textContent = `Nombre: ${registro.Nombre}, Telefono: ${registro.Telefono}, Estatus: ${registro.Estatus}`;
        contenedor.appendChild(div);
    });
}
