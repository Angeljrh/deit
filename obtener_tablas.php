<?php
$host = 'localhost';
$user = 'root';
$password = 'mysql123';
$dbname = 'deit';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Tablas excluidas
$excludedTables = [
    'almacenista', 'montacargista', 'farmaceutico', 'costurera', 
    'monitorista', 'chofer_de_reparto', 'auxiliar_de_inventarios',
    'supervisor_de_produccion', 'chofer_de_equipos_pesados', 
    'operador_de_maquina', 'inspector_de_calidad', 
    'operador_logistico', 'auxiliar_de_limpieza', 'empacador',
    'reclutadores', 'ventas', 'ventasRegistro', 'capacitacion', 'administrador'
];

$query = "SHOW TABLES";
$result = $conn->query($query);

$tables = [];
if ($result) {
    while ($row = $result->fetch_array()) {
        $tableName = $row[0];
        if (!in_array($tableName, $excludedTables)) {
            $tables[] = $tableName;
        }
    }
    $result->free();
}

$conn->close();
echo json_encode($tables);
?>