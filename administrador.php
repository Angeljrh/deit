<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario está en la sesión y si proviene de la tabla "administrador"
if (isset($_SESSION['usuario']) && $_SESSION['tabla'] == 'administrador') {
    // Obtener el nombre del usuario desde la sesión (usuario ya está autenticado)
    $usuario = $_SESSION['usuario'];
    
    // Seleccionar el campo "usuario" desde la tabla "administrador"
    $stmt = $conn->prepare("SELECT usuario FROM administrador WHERE usuario = ?");
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $userData = $resultado->fetch_assoc();
        // Enviar el nombre del usuario (campo "usuario") en formato JSON
        echo json_encode(['username' => $userData['usuario']]);
    } else {
        // Si no se encuentra el usuario, enviamos un mensaje de error
        echo json_encode(['error' => 'Usuario no encontrado']);
    }
} else {
    // Si no hay sesión activa o no es un usuario administrador, redirigir o devolver un error
    echo json_encode(['error' => 'No hay sesión activa o no tiene permisos de administrador']);
}
?>
