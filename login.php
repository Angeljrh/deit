

<?php
session_start(); // Iniciar sesión
require 'conexion.php'; // Asegúrate de que el archivo de conexión sea correcto.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para verificar el usuario en cada tabla
    $tablas = ['reclutadores', 'administrador', 'ventas', 'capacitacion'];
    $tablaEncontrada = null;

    foreach ($tablas as $tabla) {
        // Solo seleccionamos el usuario y la contraseña
        $stmt = $conn->prepare("SELECT * FROM $tabla WHERE usuario = ?");
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $userData = $resultado->fetch_assoc();

            // Verificar la contraseña usando password_verify
            if (password_verify($contrasena, $userData['contraseña'])) {
                $tablaEncontrada = $tabla;

                // Guardar información del usuario en la sesión
                $_SESSION['usuario'] = $userData['usuario'];
                $_SESSION['tabla'] = $tablaEncontrada; // Guardar el nombre de la tabla

                // Establecer cookies opcionales
                setcookie('usuario', $userData['usuario'], time() + (86400 * 30), "/"); // 30 días
                break;
            }
        }
    }

    if ($tablaEncontrada) {
        // Redirigir según la tabla
        switch ($tablaEncontrada) {
            case 'reclutadores':
                $redirect = 'vacante.html';
                break;
            case 'administrador':
                $redirect = 'administrador.html';
                break;
            case 'ventas':
                $redirect = 'ventas.html';
                break;
            case 'capacitacion':
                $redirect = 'capacitacion_dashboard.php';
                break;
            default:
                $redirect = 'index.php';
                break;
        }

        echo json_encode(['success' => true, 'redirect' => $redirect]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);
    }
}
?>


