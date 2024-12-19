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
    $id = $_POST['id'];
    $observaciones = $_POST['observaciones'];
    $estatus = $_POST['estatus'];

    $sql = "UPDATE ventasRegistro SET observaciones = ?, estatus = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $observaciones, $estatus, $id);

    if ($stmt->execute()) {
        echo "Registro guardado correctamente";
    } else {
        echo "Error al guardar el registro: " . $conn->error;
    }

    $stmt->close();
    exit();
}

$sql = "SELECT id, nombre_de_la_empresa, giro_de_la_empresa, que_produce, No_Contacto, cargo, solicitan, celular_whatsapp, telefono, extension, municipio, correo_de_contacto_correo_extra, medio_de_prospeccion, estatus FROM ventasRegistro WHERE estatus IS NULL OR estatus = ''";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-bordered'>
            <thead>
                <tr>
                    <th>Nombre de la Empresa</th>
                    <th>Giro</th>
                    <th>Qué Produce</th>
                    <th>Contacto</th>
                    <th>Cargo</th>
                    <th>Solicitan</th>
                    <th>Celular WhatsApp</th>
                    <th>Teléfono</th>
                    <th>Extensión</th>
                    <th>Municipio</th>
                    <th>Correo de Contacto</th>
                    <th>Medio de Prospección</th>
                    <th>Observaciones</th>
                    <th>Estatus</th>
                    <th>Guardar</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr id='fila-{$row['id']}'>
                <td>{$row['nombre_de_la_empresa']}</td>
                <td>{$row['giro_de_la_empresa']}</td>
                <td>{$row['que_produce']}</td>
                <td>{$row['No_Contacto']}</td>
                <td>{$row['cargo']}</td>
                <td>{$row['solicitan']}</td>
                <td>{$row['celular_whatsapp']}</td>
                <td>{$row['telefono']}</td>
                <td>{$row['extension']}</td>
                <td>{$row['municipio']}</td>
                <td>{$row['correo_de_contacto_correo_extra']}</td>
                <td>{$row['medio_de_prospeccion']}</td>
                <td><textarea name='observaciones'></textarea></td>
                <td>
                    <select name='estatus'>
                        <option value=''>Seleccione estatus</option>
                        <option value='llamad@'>Llamad@</option>
                        <option value='ocupad@'>Ocupad@</option>
                        <option value='no entro la llamada'>No Entró la Llamada</option>
                        <option value='entrevista confirmada'>Entrevista Confirmada</option>
                        <option value='no interesad@'>No Interesad@</option>
                        <option value='citad@'>Citad@</option>
                    </select>
                </td>
                <td><button class='btn btn-primary' onclick='guardarRegistro({$row['id']})'>Guardar</button></td>
            </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "No hay registros disponibles.";
}

$conn->close();
?>
