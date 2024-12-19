document.addEventListener("DOMContentLoaded", function () {
    const estatusFiltro = document.querySelector("#estatus-filtro");
    const tablaResultados = document.querySelector("#tabla-resultados tbody");

    // Función para cargar los registros y los estatus
    function cargarRegistros(estatus = "") {
        fetch(`ventasseguimiento1.php?estatus=${estatus}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                // Limpiar la tabla
                tablaResultados.innerHTML = "";

                // Limpiar los estatus existentes en el filtro
                estatusFiltro.innerHTML = `<option value="">Todos</option>`;

                // Llenar el filtro de estatus con los valores únicos desde la base de datos
                data.estatuses.forEach(estatus => {
                    const opcion = document.createElement("option");
                    opcion.value = estatus;
                    opcion.textContent = estatus;
                    estatusFiltro.appendChild(opcion);
                });

                // Recorrer los registros obtenidos y agregarlos a la tabla
                data.registros.forEach(registro => {
                    const fila = `
                        <tr>
                            <td>${registro.id}</td>
                            <td>${registro.nombre_de_la_empresa}</td>
                            <td>${registro.giro_de_la_empresa}</td>
                            <td>${registro.que_produce}</td>
                            <td>${registro.No_Contacto}</td>
                            <td>${registro.cargo}</td>
                            <td>${registro.solicitan}</td>
                            <td>${registro.celular_whatsapp}</td>
                            <td>${registro.telefono}</td>
                            <td>${registro.extension}</td>
                            <td>${registro.municipio}</td>
                            <td>${registro.correo_de_contacto_correo_extra}</td>
                            <td>${registro.medio_de_prospeccion}</td>
                            <td>${registro.observaciones}</td>
                            <td>${registro.estatus}</td>
                        </tr>
                    `;
                    tablaResultados.insertAdjacentHTML('beforeend', fila);
                });
            })
            .catch(error => console.error('Error al cargar los registros:', error));
    }

    // Escuchar el evento de cambio en el filtro de estatus
    estatusFiltro.addEventListener("change", function () {
        const estatusSeleccionado = estatusFiltro.value;
        cargarRegistros(estatusSeleccionado); // Filtrar por estatus
    });

    // Cargar todos los registros y estatus al cargar la página
    cargarRegistros();
});
