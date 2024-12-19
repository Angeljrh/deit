<?php
session_start(); // Mantener la sesión del usuario

// Conexión a la base de datos
$host = "localhost"; // Cambia según tu configuración
$user = "root"; // Cambia según tu configuración
$password = "mysql123"; // Cambia según tu configuración
$database = "deit"; // Cambia el nombre de la base de datos

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si los datos fueron enviados correctamente
if (isset($_POST['id'], $_POST['comentario'], $_POST['estatus'], $_POST['tabla'])) {
    $id = $_POST['id'];
    $comentario = $_POST['comentario'];
    $estatus = $_POST['estatus'];
    $tabla = $_POST['tabla'];
    $usuario = $_SESSION['usuario']; // Obtener el usuario de la sesión

    // Asegurar que el nombre de la tabla sea seguro
    $tablas_permitidas = [
        'almacenista', 'montacargista', 'farmaceutico', 'costurera', 'monitorista', 
        'chofer_de_reparto', 'auxiliar_de_inventarios', 'supervisor_de_produccion', 
        'chofer_de_equipos_pesados', 'operador_de_maquina', 'inspector_de_calidad', 
        'operador_logistico', 'auxiliar_de_limpieza', 'empacador', 'administrativos'
    ];

    if (in_array($tabla, $tablas_permitidas)) {
        // Actualizar el registro en la base de datos
        $sql = "UPDATE $tabla SET Comentario=?, Estatus=? WHERE Id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $comentario, $estatus, $id);

        if ($stmt->execute()) {
            echo "Registro guardado correctamente.";

            // Sumar 1 a llamadas para el usuario logueado
            $sql_llamadas = "UPDATE reclutadores SET llamadas = llamadas + 1 WHERE usuario = ?";
            $stmt_llamadas = $conn->prepare($sql_llamadas);
            $stmt_llamadas->bind_param("s", $usuario);
            $stmt_llamadas->execute();

            // Si el estatus es 'citad@', sumar 1 a citados para el usuario logueado
            if ($estatus === 'citad@') {
                $sql_citados = "UPDATE reclutadores SET citados = citados + 1 WHERE usuario = ?";
                $stmt_citados = $conn->prepare($sql_citados);
                $stmt_citados->bind_param("s", $usuario);
                $stmt_citados->execute();
            }
        } else {
            echo "Error al guardar el registro.";
        }

        $stmt->close();
    } else {
        echo "Tabla no válida.";
    }
} else {
    echo "Datos incompletos.";
}

$conn->close();
?>
