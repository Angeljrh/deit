<?php
// Datos de conexión a la base de datos
$host = 'localhost';
$dbname = 'deit';
$username = 'root';
$password = 'mysql123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lista de tablas a excluir
    $excluirTablas = ['ventas', 'ventasRegistro', 'capacitacion', 'administrador', 'reclutadores'];
    $placeholders = implode(',', array_fill(0, count($excluirTablas), '?'));

    // Consulta para obtener los nombres de las tablas excluyendo las especificadas
    $stmt = $pdo->prepare("SHOW TABLES WHERE Tables_in_$dbname NOT IN ($placeholders)");
    $stmt->execute($excluirTablas);
    $tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Convertir el resultado a JSON y enviarlo
    echo json_encode($tablas);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
