document.getElementById("nipForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let nuevaTabla = document.getElementById("nueva").value.trim();

    if (nuevaTabla) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "nuevavacante.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let response = xhr.responseText.trim();
                alert(response);
                document.getElementById("nueva").value = ""; // Limpiar el campo de texto
            }
        };

        xhr.send("nombreTabla=" + encodeURIComponent(nuevaTabla));
    } else {
        alert("Por favor ingrese un nombre para la tabla.");
    }
});

// Cargar tablas dinámicamente
document.addEventListener("DOMContentLoaded", function() {
    let tablaSelect = document.getElementById("Tabla");

    // Cargar tablas, excluyendo las especificadas
    fetch("nuevavacante.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "accion=cargarTablas"
    })
    .then(response => response.json())
    .then(data => {
        data.forEach(tabla => {
            if (!["ventas", "ventasRegistro", "capacitacion", "reclutadores", "administrador"].includes(tabla)) {
                let option = document.createElement("option");
                option.value = tabla;
                option.textContent = tabla;
                tablaSelect.appendChild(option);
            }
        });
    });

    // Actualizar select de estatus y fecha según la tabla seleccionada
    tablaSelect.addEventListener("change", function() {
        cargarEstatus(tablaSelect.value);
        cargarFechas(tablaSelect.value);
    });
});

// Cargar estatus dinámicamente
function cargarEstatus(tabla) {
    let estatusSelect = document.getElementById("Estatus");
    estatusSelect.innerHTML = ""; // Limpiar opciones previas

    fetch("nuevavacante.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "accion=cargarEstatus&tablaSeleccionada=" + encodeURIComponent(tabla)
    })
    .then(response => response.json())
    .then(data => {
        data.forEach(estatus => {
            let option = document.createElement("option");
            option.value = estatus;
            option.textContent = estatus;
            estatusSelect.appendChild(option);
        });
    });
}

// Cargar fechas dinámicamente
function cargarFechas(tabla) {
    let fechaSelect = document.getElementById("Fecha");
    fechaSelect.innerHTML = ""; // Limpiar opciones previas

    fetch("nuevavacante.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "accion=cargarFechas&tablaSeleccionada=" + encodeURIComponent(tabla)
    })
    .then(response => response.json())
    .then(data => {
        data.forEach(fecha => {
            let option = document.createElement("option");
            option.value = fecha;
            option.textContent = fecha;
            fechaSelect.appendChild(option);
        });
    });
}

// Confirmar eliminación
document.getElementById("deleteForm").addEventListener("submit", function (event) {
    event.preventDefault();

    if (confirm("¿Estás seguro que quieres eliminar estos registros?")) {
        let tabla = document.getElementById("Tabla").value;
        let estatus = document.getElementById("Estatus").value;

        fetch("nuevavacante.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `accion=eliminarRegistros&tablaSeleccionada=${encodeURIComponent(tabla)}&estatus=${encodeURIComponent(estatus)}`
        }).then(response => response.text()).then(data => {
            alert("Registros eliminados con éxito.");
        });
    }
});
