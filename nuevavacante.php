<?php
include 'conexion.php';

// Crear nueva tabla
if (isset($_POST['nombreTabla'])) {
    $nombreTabla = $_POST['nombreTabla'];

    // Validar el nombre de la tabla
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $nombreTabla)) {
        echo "El nombre de la tabla no es válido. Solo se permiten letras, números y guiones bajos.";
        exit;
    }

    // Escapar el nombre de la tabla
    $nombreTabla = mysqli_real_escape_string($conn, $nombreTabla);

    // Crear la tabla si no existe
    $sql = "CREATE TABLE IF NOT EXISTS `$nombreTabla` (
       Id INT AUTO_INCREMENT PRIMARY KEY,
       Nombre VARCHAR(60),
       Edad INT,
       Telefono VARCHAR(20),
       Ubicacion VARCHAR(30),
       Comentario VARCHAR(300),
       Estatus VARCHAR(30),
       Estatusdos VARCHAR(60),
       Usuario VARCHAR(60),
       FOREIGN KEY (Usuario) REFERENCES reclutadores (usuario),
       Fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );";

    if (mysqli_query($conn, $sql)) {
        echo "La tabla '$nombreTabla' se ha creado con éxito.";
    } else {
        echo "Error al crear la tabla: " . mysqli_error($conn);
    }
}

// Manejar otras acciones como cargar tablas, estatus y fechas
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion == "cargarTablas") {
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);
        $tablas = [];
        while ($row = mysqli_fetch_row($result)) {
            $tablas[] = $row[0];
        }
        echo json_encode($tablas);
    } elseif ($accion == "cargarEstatus") {
        $tablaSeleccionada = $_POST['tablaSeleccionada'];
        $tablaSeleccionada = mysqli_real_escape_string($conn, $tablaSeleccionada);

        $sql = "SELECT DISTINCT estatus FROM `$tablaSeleccionada`";
        $result = mysqli_query($conn, $sql);
        $estatus = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $estatus[] = $row['estatus'];
        }
        echo json_encode($estatus);
    } elseif ($accion == "cargarFechas") {
        $tablaSeleccionada = $_POST['tablaSeleccionada'];
        $tablaSeleccionada = mysqli_real_escape_string($conn, $tablaSeleccionada);

        $sql = "SELECT DISTINCT Fecha_modificacion FROM `$tablaSeleccionada`";
        $result = mysqli_query($conn, $sql);
        $fechas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $fechas[] = $row['Fecha_modificacion'];
        }
        echo json_encode($fechas);
    } elseif ($accion == "eliminarRegistros") {
        $tablaSeleccionada = $_POST['tablaSeleccionada'];
        $estatus = $_POST['estatus'];

        $tablaSeleccionada = mysqli_real_escape_string($conn, $tablaSeleccionada);
        $estatus = mysqli_real_escape_string($conn, $estatus);

        $sql = "DELETE FROM `$tablaSeleccionada` WHERE estatus='$estatus'";
        if (mysqli_query($conn, $sql)) {
            echo "Registros eliminados con éxito.";
        } else {
            echo "Error al eliminar registros: " . mysqli_error($conn);
        }
    }
}
?>
