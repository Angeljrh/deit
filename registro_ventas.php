<?php
// Incluye el archivo de conexión
require_once 'conexion.php';

// Verifica si se recibieron datos mediante el método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoge los datos del formulario usando el método POST
    $nombre_empresa = $_POST['empresa'] ?? '';
    $numero_contacto = $_POST['contacto'] ?? '';
    $ubicacion = $_POST['ubicacion'] ?? '';
    $correo_contacto = $_POST['correo'] ?? '';

    // Validación básica de los campos
    if (empty($nombre_empresa) || empty($numero_contacto) || empty($ubicacion) || empty($correo_contacto)) {
        echo "Por favor, completa todos los campos requeridos.";
        exit;
    }

    // Inserta los datos en la tabla ventasRegistro
    $sql = "INSERT INTO ventasRegistro (
        nombre_de_la_empresa, 
        No_Contacto, 
        municipio, 
        correo_de_contacto_correo_extra
    ) VALUES (?, ?, ?, ?)";

    // Prepara la consulta para evitar inyecciones SQL
    if ($stmt = $conn->prepare($sql)) {
        // Vincula los parámetros
        $stmt->bind_param("ssss", $nombre_empresa, $numero_contacto, $ubicacion, $correo_contacto);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            echo "Datos guardados exitosamente.";
        } else {
            echo "Error al guardar los datos: " . $stmt->error;
        }

        // Cierra la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    // Cierra la conexión
    $conn->close();
} else {
    echo "Método de solicitud no válido.";
}
?>
