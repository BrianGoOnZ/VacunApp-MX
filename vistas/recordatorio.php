<?php
// Conexión (usando tus datos)
$conn = new mysqli("localhost", "root", "abril123", "vacunapp");

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