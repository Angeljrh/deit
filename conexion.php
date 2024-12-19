<?php
$servername = "localhost";
$username = "deit2024"; // Cambia si es necesario
$password = "mysql123#"; // Cambia si es necesario
$dbname = "deit"; // Cambia por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
