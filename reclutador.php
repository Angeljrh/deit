<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode([]);
    exit;
}

$host = "localhost";
$user = "root";
$password = "mysql123";
$database = "deit";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $comentario = $_POST['comentario'];
    $estatus = $_POST['estatus'];
    $tabla = $_POST['tabla'];

    $sql = "UPDATE $tabla SET Comentario = ?, Estatus = ? WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $comentario, $estatus, $id);

    if ($stmt->execute()) {
        echo "Registro guardado correctamente";
    } else {
        echo "Error al guardar el registro: " . $conn->error;
    }

    $stmt->close();
    exit();
}

if (isset($_GET['tabla'])) {
    $tabla = $_GET['tabla'];
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $usuarioLogueado = $_SESSION['usuario'];

    $sql = "SELECT Id, Nombre, Edad, Telefono, Ubicacion 
            FROM $tabla 
            WHERE Usuario = ? AND (Estatus IS NULL OR Estatus = '')
            LIMIT 5 OFFSET ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $usuarioLogueado, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table class='table table-striped'><thead><tr><th>ID</th><th>Nombre</th><th>Edad</th><th>Teléfono</th><th>Ubicación</th><th>Comentario</th><th>Estatus</th><th>Acciones</th></tr></thead><tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr id='fila-{$row['Id']}'>";
            echo "<td>{$row['Id']}</td>";
            echo "<td>{$row['Nombre']}</td>";
            echo "<td>{$row['Edad']}</td>";
            echo "<td>{$row['Telefono']}</td>";
            echo "<td>{$row['Ubicacion']}</td>";
            echo "<td><textarea name='comentario'></textarea></td>";
            echo "<td><select name='estatus'><option value=''>Seleccionar</option><option value='Contactado'>Contactado</option><option value='No Contactado'>No Contactado</option><option value='Citado'>Citado</option><option value='No Interesado'>No Interesado</option></select></td>";
            echo "<td><button class='btn btn-success' onclick='guardarRegistro({$row['Id']}, \"$tabla\")'>Guardar</button></td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No hay más registros disponibles</p>";
    }
    $stmt->close();
}

$conn->close();
?>
