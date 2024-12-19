<?php
$host = "localhost";
$user = "root";
$password = "mysql123";
$database = "deit";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_de_la_empresa = $_POST['nombre_de_la_empresa'];
    $giro_de_la_empresa = $_POST['giro_de_la_empresa'];
    $que_produce = $_POST['que_produce'];
    $No_Contacto = $_POST['No_Contacto'];
    $cargo = $_POST['cargo'];
    $solicitan = $_POST['solicitan'];
    $celular_whatsapp = $_POST['celular_whatsapp'];
    $telefono = $_POST['telefono'];
    $extension = $_POST['extension'];
    $municipio = $_POST['municipio'];
    $correo_de_contacto_correo_extra = $_POST['correo_de_contacto_correo_extra'];
    $medio_de_prospeccion = $_POST['medio_de_prospeccion'];

    $sql = "INSERT INTO ventasRegistro (nombre_de_la_empresa, giro_de_la_empresa, que_produce, No_Contacto, cargo, solicitan, celular_whatsapp, telefono, extension, municipio, correo_de_contacto_correo_extra, medio_de_prospeccion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisssissss", $nombre_de_la_empresa, $giro_de_la_empresa, $que_produce, $No_Contacto, $cargo, $solicitan, $celular_whatsapp, $telefono, $extension, $municipio, $correo_de_contacto_correo_extra, $medio_de_prospeccion);

    if ($stmt->execute()) {
        echo "Registro guardado correctamente";
    } else {
        echo "Error al guardar el registro: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
