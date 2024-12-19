<?php
$servername = "localhost";
$username = "root";
$password = "mysql123";
$dbname = "deit";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar la consulta SQL para registros
$sql = "SELECT * FROM ventasRegistro";
$params = [];

// Verificar si hay un filtro de estatus y ajustar la consulta
if (isset($_GET['estatus']) && !empty($_GET['estatus'])) {
    $estatus = $_GET['estatus'];
    $sql .= " WHERE estatus = ?";
    $params[] = $estatus;
}

// Preparar la consulta
$stmt = $conn->prepare($sql);

// Si hay parámetros, ligarlos a la consulta preparada
if (!empty($params)) {
    $stmt->bind_param("s", $params[0]);
}

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

// Consultar los estatus únicos para el filtro
$sql_estatus = "SELECT DISTINCT estatus FROM ventasRegistro";
$result_estatus = $conn->query($sql_estatus);

// Preparar los datos para la respuesta en JSON
$registros = [];
$estatuses = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
}

if ($result_estatus->num_rows > 0) {
    while ($row_estatus = $result_estatus->fetch_assoc()) {
        $estatuses[] = $row_estatus['estatus'];
    }
}

// Enviar los datos en formato JSON
echo json_encode([
    'registros' => $registros,
    'estatuses' => $estatuses
]);

// Cerrar conexiones y liberar recursos
$stmt->close();
$conn->close();
exit;
?>