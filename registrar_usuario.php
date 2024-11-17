<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grupo3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$password = $_POST['password'];

// Verificar si el correo ya existe en la base de datos
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Si el correo ya existe, redirigir con un mensaje de error
    header("Location: registro.html?status=error");
    exit();
} else {
    // Encriptar la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta para insertar al nuevo usuario
    $stmt = $conn->prepare("INSERT INTO users (nombre, email, telefono, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $telefono, $passwordHash);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: registro.html?status=exito");
    } else {
        header("Location: registro.html?status=error");
    }

    $stmt->close();
}

$conn->close();
exit();
?>
