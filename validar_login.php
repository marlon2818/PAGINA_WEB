<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración
$dbname = "grupo3"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Usar consulta preparada para evitar inyección SQL
$sql = "SELECT * FROM users WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email); // 's' para string
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Inicio de sesión exitoso
        $_SESSION['user'] = $row['nomuser'];
        header("Location: GlampingCañaberal.html");
        exit();
    } else {
        // Contraseña incorrecta
        header("Location: iniciosesion.html?error=contraseña_incorrecta");
        exit();
    }
} else {
    // Usuario no encontrado
    header("Location: iniciosesion.html?error=usuario_no_encontrado");
    exit();
}

$conn->close();
?>
