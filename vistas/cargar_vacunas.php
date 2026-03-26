<?php
// conexion
$servidor = "localhost";
$usuario  = "root";
$password = "abril123";
$base_datos = "vacunapp"; 

$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// 2. Recibir los datos del formulario (los nombres en $_POST deben coincidir con el 'name' de tus inputs)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_vacuna = $_POST['vacuna'];
    $enfermedad    = $_POST['enfermedad'];
    $dosis         = $_POST['dosis'];
    $fecha         = $_POST['fecha'];

    // 3. Preparar la consulta SQL
    // Nota: Asegúrate de que los nombres de las columnas (nombre_vacuna, enfermedad, etc.) sean iguales a los de tu tabla en MySQL
    $sql = "INSERT INTO vacunas (nombre_vacuna, enfermedad, dosis, fecha) 
            VALUES ('$nombre_vacuna', '$enfermedad', '$dosis', '$fecha')";

    // 4. Ejecutar y redireccionar
    if (mysqli_query($conexion, $sql)) {
        // Si todo sale bien, nos regresa a la página de la tabla
        header("Location: vacunas.php");
        exit();
    } else {
        echo "Error al guardar los datos: " . mysqli_error($conexion);
    }
}

// Cerrar la conexión
mysqli_close($conexion);
?>