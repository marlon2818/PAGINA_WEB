<?php
$servername = "localhost";
$username = "root"; // Cambia este valor si tu usuario es diferente
$password = ""; // Cambia este valor si tienes una contraseña
$dbname = "grupo3"; // Cambia este valor al nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conexión exitosa a la base de datos '$dbname'.";
}

// Cerrar la conexión
$conn->close();
?>
