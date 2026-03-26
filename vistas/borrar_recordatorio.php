<?php
// 1. Conexión
$conn = new mysqli("localhost", "root", "abril123", "vacunapp");

if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}

// 2. Verificar que recibimos el ID por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 3. Borrar de la tabla usando tu columna 'id'
    $sql = "DELETE FROM recordatorios WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Regresamos a la página de notificaciones
        header("Location: notificaciones.php");
        exit();
    } else {
        echo "Error al borrar: " . $conn->error;
    }
}

$conn->close();
?>