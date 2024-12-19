<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "mysql123";
$dbname = "deit";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$tabla = isset($_POST['tabla']) ? $_POST['tabla'] : '';
$nombre = isset($_POST['nombres']) ? $_POST['nombres'] : '';
$edad = isset($_POST['edad']) ? $_POST['edad'] : '';
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
$ubicacion = isset($_POST['ubicacion']) ? $_POST['ubicacion'] : '';

// Verificar que no haya campos vacíos
if (empty($tabla) || empty($nombre) || empty($edad) || empty($telefono) || empty($ubicacion)) {
    die("Error: Todos los campos son obligatorios.");
}

// Verificar que la tabla sea válida
$tablas_permitidas = array("almacenista", "montacargista", "farmaceutico", "costurera", "chofer_de_reparto", 
                           "auxiliar_de_inventarios", "supervisor_de_produccion", "chofer_de_equipos_pesados", 
                           "operador_de_maquinaria", "inspector_de_calidad", "operador_logistico", "auxiliar_de_limpieza", 
                           "empacador");

if (in_array($tabla, $tablas_permitidas)) {
    // Preparar la consulta SQL
    $sql = "INSERT INTO $tabla (Nombre, Edad, Telefono, Ubicacion) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $nombre, $edad, $telefono, $ubicacion);

    // Ejecutar la consulta y verificar si fue exitosa
    if ($stmt->execute()) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $stmt->close();
} else {
    echo "Tabla no válida.";
}

$conn->close();
?>


