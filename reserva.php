<?php
// Configuración de la base de datos
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'grupo3'; // Cambia al nombre de tu base de datos

// Conexión a la base de datos
$conn = new mysqli($host, $user, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombreCompleto = $conn->real_escape_string($_POST['nombre_completo']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $fechaIngreso = $conn->real_escape_string($_POST['fecha_ingreso']);
    $fechaSalida = $conn->real_escape_string($_POST['fecha_salida']);
    $numeroPersonas = (int) $_POST['numero_personas'];

    // Validación de datos (opcional)
    if (empty($nombreCompleto) || empty($telefono) || empty($correo) || empty($fechaIngreso) || empty($fechaSalida) || $numeroPersonas <= 0) {
        header("Location: reserva.html?status=error");
        exit;
    }

    // Insertar la reserva en la base de datos
    $sql = "INSERT INTO reservas (nombre_completo, telefono, correo, fecha_ingreso, fecha_salida, numero_personas) 
            VALUES ('$nombreCompleto', '$telefono', '$correo', '$fechaIngreso', '$fechaSalida', $numeroPersonas)";

    if ($conn->query($sql) === TRUE) {
        // Redirigir con estado de éxito
        header("Location: reserva.html?status=exito");
    } else {
        // Redirigir con estado de error
        header("Location: reserva.html?status=error");
    }
    exit;
}
?>
