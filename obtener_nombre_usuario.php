<?php
session_start();

// Verificar si el usuario está logueado y su nombre está en la sesión
if (isset($_SESSION['usuario'])) {
    echo $_SESSION['usuario']; // Devolver el nombre del usuario
} else {
    echo "Usuario desconocido"; // Mensaje por defecto si no hay usuario en la sesión
}
?>
