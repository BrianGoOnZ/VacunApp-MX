<?php
// 1. CONEXIÓN (Asegúrate de que los datos sean correctos)
$conn = new mysqli("localhost", "root", "abril123", "vacunapp");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 2. RECIBIR DATOS DEL FORMULARIO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Estos nombres ('titulo', 'fecha_recordatorio', 'descripcion') 
    // deben ser los mismos que pusiste en el atributo 'name' de tu HTML
    $titulo = $_POST['titulo'];
    $fecha = $_POST['fecha_recordatorio'];
    $descripcion = $_POST['descripcion'];

    // 3. INSERTAR EN LA TABLA 'recordatorios'
    // Verifica que en phpMyAdmin tu tabla tenga estas columnas exactas
    $sql = "INSERT INTO recordatorios (titulo, fecha_recordatorio, descripcion) 
            VALUES ('$titulo', '$fecha', '$descripcion')";

    if ($conn->query($sql) === TRUE) {
        // Si se guarda, te regresa a vacunas.php para que veas que funcionó
        header("Location: vacunas.php");
        exit();
    } else {
        echo "Error al guardar recordatorio: " . $conn->error;
    }
}

$conn->close();
?>