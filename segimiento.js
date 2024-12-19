document.addEventListener("DOMContentLoaded", function() {
    cargarEmpresas();

    document.getElementById("opciones").addEventListener("change", function() {
        const empresa = this.value;
        if (empresa) {
            cargarDatosTabla(empresa);
            cargarFiltros(empresa);
        }
    });

    // Aplicar el filtro al cambiar cada select
    document.getElementById("reclutadorFilter").addEventListener("change", aplicarFiltros);
    document.getElementById("ubicacionFilter").addEventListener("change", aplicarFiltros);
    document.getElementById("fechaFilter").addEventListener("change", aplicarFiltros);
    document.getElementById("estatusFilter").addEventListener("change", aplicarFiltros);
});

function cargarEmpresas() {
    fetch("segimiento.php?action=getEmpresas")
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById("opciones");
            data.forEach(empresa => {
                const option = document.createElement("option");
                option.value = empresa;
                option.textContent = empresa;
                select.appendChild(option);
            });
        });
}

function cargarDatosTabla(empresa) {
    const vacanteTable = document.getElementById("vacanteTable");
    const vacanteBody = document.getElementById("vacanteBody");
    vacanteBody.innerHTML = "";

    fetch(`segimiento.php?action=getDatos&empresa=${empresa}`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                vacanteTable.style.display = "table";
                data.forEach(row => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${row.Usuario}</td>
                        <td>${row.Nombre}</td>
                        <td>${row.Edad}</td>
                        <td>${row.Telefono}</td>
                        <td>${row.Ubicacion}</td>
                        <td>${row.Fecha_modificacion}</td>
                        <td>${row.Comentario}</td>
                        <td>${row.Estatus}</td>
                        <td>
                            <input type="text" value="${row.Estatusdos || ''}" data-id="${row.Id}" class="estatusdos-input">
                            <button class="guardar-btn" data-id="${row.Id}">Guardar</button>
                        </td>
                    `;
                    tr.dataset.usuario = row.Usuario;
                    tr.dataset.ubicacion = row.Ubicacion;
                    tr.dataset.fecha = row.Fecha_modificacion;
                    tr.dataset.estatus = row.Estatus;
                    vacanteBody.appendChild(tr);
                });
            } else {
                vacanteTable.style.display = "none";
            }
        });
}

function cargarFiltros(empresa) {
    fetch(`segimiento.php?action=getUsuarios&empresa=${empresa}`)
        .then(response => response.json())
        .then(usuarios => {
            const usuarioSelect = document.getElementById("reclutadorFilter");
            usuarioSelect.innerHTML = "<option value=''>Todos</option>";
            usuarios.forEach(usuario => {
                const option = document.createElement("option");
                option.value = usuario;
                option.textContent = usuario;
                usuarioSelect.appendChild(option);
            });
        });

    fetch(`segimiento.php?action=getUbicaciones&empresa=${empresa}`)
        .then(response => response.json())
        .then(ubicaciones => {
            const ubicacionSelect = document.getElementById("ubicacionFilter");
            ubicacionSelect.innerHTML = "<option value=''>Todas</option>";
            ubicaciones.forEach(ubicacion => {
                const option = document.createElement("option");
                option.value = ubicacion;
                option.textContent = ubicacion;
                ubicacionSelect.appendChild(option);
            });
        });

    fetch(`segimiento.php?action=getFechas&empresa=${empresa}`)
        .then(response => response.json())
        .then(fechas => {
            const fechaSelect = document.getElementById("fechaFilter");
            fechaSelect.innerHTML = "<option value=''>Todas</option>";
            const uniqueDates = Array.from(new Set(fechas));  // Eliminar fechas duplicadas
            uniqueDates.forEach(fecha => {
                const option = document.createElement("option");
                option.value = fecha;
                option.textContent = fecha;
                fechaSelect.appendChild(option);
            });
        });

    fetch(`segimiento.php?action=getEstatus&empresa=${empresa}`)
        .then(response => response.json())
        .then(estatus => {
            const estatusSelect = document.getElementById("estatusFilter");
            estatusSelect.innerHTML = "<option value=''>Todos</option>";
            estatus.forEach(est => {
                const option = document.createElement("option");
                option.value = est;
                option.textContent = est;
                estatusSelect.appendChild(option);
            });
        });
}

// Función para aplicar los filtros en la tabla
function aplicarFiltros() {
    const usuarioFiltro = document.getElementById("reclutadorFilter").value;
    const ubicacionFiltro = document.getElementById("ubicacionFilter").value;
    const fechaFiltro = document.getElementById("fechaFilter").value;
    const estatusFiltro = document.getElementById("estatusFilter").value;

    const filas = document.querySelectorAll("#vacanteBody tr");

    filas.forEach(fila => {
        const coincideUsuario = !usuarioFiltro || fila.dataset.usuario === usuarioFiltro;
        const coincideUbicacion = !ubicacionFiltro || fila.dataset.ubicacion === ubicacionFiltro;
        const coincideFecha = !fechaFiltro || fila.dataset.fecha === fechaFiltro;
        const coincideEstatus = !estatusFiltro || fila.dataset.estatus === estatusFiltro;

        if (coincideUsuario && coincideUbicacion && coincideFecha && coincideEstatus) {
            fila.style.display = "";
        } else {
            fila.style.display = "none";
        }
    });
}

document.getElementById("vacanteBody").addEventListener("click", function(event) {
    if (event.target.classList.contains("guardar-btn")) {
        const id = event.target.getAttribute("data-id");
        const estatusdosInput = event.target.previousElementSibling;
        const estatusdosValue = estatusdosInput.value;

        fetch("segimiento.php?action=guardarEstatusDos", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}&estatusdos=${estatusdosValue}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Estatus dos guardado correctamente");
            } else {
                alert("Error al guardar estatus dos");
            }
        });
    }
});