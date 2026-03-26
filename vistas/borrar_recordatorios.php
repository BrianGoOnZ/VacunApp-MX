<?php
// 1. Conexión a la  base de datos
$name = 'localhost';
$user = 'root';
$pass = 'abril123';
$db   = 'vacunapp'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM recordatorios WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: notificaciones.php");
        exit();
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
}
$conn->close();
?>