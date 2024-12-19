<?php
session_start();
session_destroy();
setcookie('usuario', '', time() - 3600, "/"); // Eliminar la cookie
header("Location: index.html"); // Redirigir al inicio de sesión
exit();
?>
