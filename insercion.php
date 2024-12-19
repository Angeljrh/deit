<?php
require 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tabla = $_POST['tabla'];
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT); // Encriptar la contraseña

    // Definir la consulta según la tabla seleccionada
    switch ($tabla) {
        case 'reclutadores':
            $sql = "INSERT INTO reclutadores (usuario, contraseña) VALUES (?, ?)";
            break;
        case 'ventas':
            $sql = "INSERT INTO ventas (usuario, contraseña) VALUES (?, ?)";
            break;
        case 'administrador':
            $sql = "INSERT INTO administrador (usuario, contraseña) VALUES (?, ?)";
            break;
        case 'capacitación':
            $sql = "INSERT INTO capacitación (usuario, contraseña) VALUES (?, ?)";
            break;
        case 'ventasRegistro':
            $sql = "INSERT INTO ventasRegistro (usuario, contraseña) VALUES (?, ?)";
            break;
        default:
            echo "Tabla no válida.";
            exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $usuario, $contrasena);

    if ($stmt->execute()) {
        echo "Usuario insertado correctamente.";
    } else {
        echo "Error al insertar usuario.";
    }

    $stmt->close();
    $conn->close();
}
?>

