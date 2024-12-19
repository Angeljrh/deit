<?php
$host = 'localhost';
$db = 'deit';
$user = 'root';
$pass = 'mysql123';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getReclutadores':
        obtenerReclutadores($conn);
        break;
    case 'getTablas':
        obtenerTablas($conn);
        break;
    case 'getFechas':
        obtenerFechas($conn);
        break;
    case 'enviarRegistros':
        enviarRegistros($conn);
        break;
    default:
        echo json_encode(['error' => 'Acción no válida']);
}

function obtenerReclutadores($conn) {
    $query = "SELECT usuario FROM reclutadores";
    $result = $conn->query($query);
    $reclutadores = [];
    while ($row = $result->fetch_assoc()) {
        $reclutadores[] = $row;
    }
    echo json_encode($reclutadores);
}

function obtenerTablas($conn) {
    $query = "SHOW TABLES";
    $result = $conn->query($query);
    $excluidas = ['ventas', 'ventasRegistro', 'capacitacion', 'reclutadores', 'administrador'];
    $tablas = [];
    while ($row = $result->fetch_row()) {
        if (!in_array($row[0], $excluidas)) {
            $tablas[] = $row[0];
        }
    }
    echo json_encode($tablas);
}

function obtenerFechas($conn) {
    $tabla = $conn->real_escape_string($_GET['tabla']);
    $query = "SELECT DISTINCT DATE(Fecha_modificacion) AS fecha FROM $tabla";
    $result = $conn->query($query);
    $fechas = [];
    while ($row = $result->fetch_assoc()) {
        $fechas[] = $row['fecha'];
    }
    echo json_encode($fechas);
}

function enviarRegistros($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    $reclutador = $conn->real_escape_string($data['reclutador']);
    $tabla = $conn->real_escape_string($data['vacante']);
    $fecha = $conn->real_escape_string($data['fecha']);

    $query = "UPDATE $tabla SET Usuario = '$reclutador' WHERE DATE(Fecha_modificacion) = '$fecha' AND Usuario IS NULL LIMIT 5";
    $success = $conn->query($query);

    echo json_encode(['success' => $success]);
}

$conn->close();
?>
