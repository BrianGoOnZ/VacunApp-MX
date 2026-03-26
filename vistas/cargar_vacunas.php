<?php
// 1. Configuración de la conexión
$servidor = "localhost";
$usuario  = "root";
$password = "abril123";
$base_datos = "vacunapp";

// Crear la conexión
$conn = new mysqli($servidor, $usuario, $password, $base_datos);


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 2. Verifica que los datos lleguen por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibimos los datos del formulario (los 'name' del modal)
    $nombre_vacuna = $_POST['nombre_vacuna'];
    $fecha_aplicacion = $_POST['fecha_aplicacion'];
    $lote = $_POST['lote'];
    $proxima_cita = $_POST['proxima_cita'];

    // 3. Preparar la consulta SQL
    $sql = "INSERT INTO vacunas (nombre_vacuna, fecha_aplicacion, lote, proxima_cita) 
            VALUES ('$nombre_vacuna', '$fecha_aplicacion', '$lote', '$proxima_cita')";


    if ($conn->query($sql) === TRUE) {
        // Si todo sale bien, regresa automáticamente a la lista de vacunas
        header("Location: vacunas.php");
        exit();
    } else {
        echo "Error al registrar la vacuna: " . $conn->error;
    }
}

// Cerrar la conexión al finalizar
$conn->close();
?>