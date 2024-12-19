<?php
header('Content-Type: application/json'); // Especificar que la respuesta es JSON

$host = 'localhost';
$user = 'root';
$password = 'mysql123';
$dbname = 'deit';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

if (isset($_POST['vacante'], $_POST['nombre'], $_POST['edad'], $_POST['telefono'], $_POST['ubicacion'])) {
    $vacante = $_POST['vacante'];
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $edad = $conn->real_escape_string($_POST['edad']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']);

    $query = "INSERT INTO $vacante (Nombre, Edad, Telefono, Ubicacion) VALUES ('$nombre', '$edad', '$telefono', '$ubicacion')";
    
    if ($conn->query($query) === TRUE) {
        echo json_encode(["success" => "Registro insertado correctamente."]);
    } else {
        echo json_encode(["error" => "Error al insertar: " . $conn->error]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos."]);
}

$conn->close();
?>
