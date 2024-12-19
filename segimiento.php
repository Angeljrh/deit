
<?php
header('Content-Type: application/json');
$conexion = new mysqli("localhost", "root", "mysql123", "deit");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getEmpresas':
        $excluidas = ["ventas", "ventasRegistro", "capacitacion", "administrador", "reclutadores"];
        $resultado = $conexion->query("SHOW TABLES");
        $empresas = [];
        while ($fila = $resultado->fetch_array()) {
            $tabla = $fila[0];
            if (!in_array($tabla, $excluidas)) {
                $empresas[] = $tabla;
            }
        }
        echo json_encode($empresas);
        break;

    case 'getDatos':
        $empresa = $conexion->real_escape_string($_GET['empresa']);
        $query = "SELECT Id, Nombre, Edad, Telefono, Ubicacion, Comentario, Estatus, Estatusdos, Usuario, Fecha_modificacion FROM $empresa";
        $resultado = $conexion->query($query);
        $datos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        echo json_encode($datos);
        break;

    case 'guardarEstatusDos':
        $id = $_POST['id'];
        $estatusdos = $_POST['estatusdos'];
            // Cambié $conn por $conexion, ya que la conexión se llama $conexion
            $stmt = $conexion->prepare("UPDATE candidatos SET Estatusdos = ? WHERE Id = ?");
            $stmt->bind_param("si", $estatusdos, $id);
            if ($stmt->execute()) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false]);
            }
            break;
        
    case 'getUsuarios':
        // Filtro de Usuario
        $empresa = $conexion->real_escape_string($_GET['empresa']);
        $query = "SELECT DISTINCT Usuario FROM $empresa";
        $result = $conexion->query($query);
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row['Usuario'];
        }
        echo json_encode($usuarios);
        break;

    case 'getUbicaciones':
        // Filtro de Ubicación
        $empresa = $conexion->real_escape_string($_GET['empresa']);
        $query = "SELECT DISTINCT Ubicacion FROM $empresa";
        $result = $conexion->query($query);
        $ubicaciones = [];
        while ($row = $result->fetch_assoc()) {
            $ubicaciones[] = $row['Ubicacion'];
        }
        echo json_encode($ubicaciones);
        break;

        case 'getFechas':
            $empresa = $conexion->real_escape_string($_GET['empresa']);
            $query = "SELECT DISTINCT Fecha_modificacion FROM $empresa";
            $result = $conexion->query($query);
            $fechas = [];
            while ($row = $result->fetch_assoc()) {
                $fechas[] = $row['Fecha_modificacion'];
            }
            echo json_encode($fechas);
            break;

    case 'getEstatus':
        // Filtro de Estatus
        $empresa = $conexion->real_escape_string($_GET['empresa']);
        $query = "SELECT DISTINCT Estatus FROM $empresa";
        $result = $conexion->query($query);
        $estatus = [];
        while ($row = $result->fetch_assoc()) {
            $estatus[] = $row['Estatus'];
        }
        echo json_encode($estatus);
        break;

    default:
        echo json_encode(["error" => "Acción no válida"]);
}

$conexion->close();
?>
