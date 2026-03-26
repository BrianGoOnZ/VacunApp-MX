<?php
// 1. Configuración de la conexión (Asegúrate de que el nombre de la BD sea correcto)
$servidor = "localhost";
$usuario  = "root";
$password = "";
$base_datos = "vacunapp"; 

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 2. RECIBIR DATOS
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vacuna = $_POST['vacuna'];
    $enfermedad = $_POST['enfermedad'];
    $dosis = $_POST['dosis'];
    $fecha = $_POST['fecha'];

    // 3. INSERTAR (Asegúrate que los nombres de las columnas coincidan con tu BD)
    $sql = "INSERT INTO vacunas (nombre_vacuna, enfermedad, dosis, fecha) 
            VALUES ('$vacuna', '$enfermedad', '$dosis', '$fecha')";

    if ($conn->query($sql) === TRUE) {
        // Regresa a la tabla si todo sale bien
        header("Location: vacunas.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>