<?php
include '../database/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $desc   = $_POST['descripcion'];
    $fecha  = $_POST['fecha_recordatorio'];
    $sql = "INSERT INTO recordatorios (titulo, descripcion, fecha_recordatorio) 
            VALUES ('$titulo', '$desc', '$fecha')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../vistas/vacunas.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>