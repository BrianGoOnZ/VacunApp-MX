<?php
// 1. Conexión a la base de datos
$name = 'localhost';
$user = 'root';
$pass = 'abril123';
$db   = 'vacunapp'; 

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha_recordatorio'];

    // Insertar en la tabla recordatorios
    $sql = "INSERT INTO recordatorios (titulo, descripcion, fecha_recordatorio) 
            VALUES ('$titulo', '$descripcion', '$fecha')";

    if ($conn->query($sql) === TRUE) {
        // Al guardar, te regresa a la página de vacunas
        header("Location: vacunas.php");
        exit();
    } else {
        echo "Error al crear recordatorio: " . $conn->error;
    }
}

$conn->close();
?>