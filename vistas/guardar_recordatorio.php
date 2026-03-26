<?php
$conn = new mysqli("localhost", "root", "abril123", "vacunapp");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $desc   = $_POST['descripcion'];
    $fecha  = $_POST['fecha_recordatorio'];

    // Insertamos en tus columnas reales
    $sql = "INSERT INTO recordatorios (titulo, descripcion, fecha_recordatorio) 
            VALUES ('$titulo', '$desc', '$fecha')";

    if ($conn->query($sql) === TRUE) {
        header("Location: vacunas.php"); // Regresa a la página principal
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>