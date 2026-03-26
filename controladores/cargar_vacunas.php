<?php
include '../database/db.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vacuna = mysqli_real_escape_string($conexion, $_POST['vacuna']);
    $enfermedad = mysqli_real_escape_string($conexion, $_POST['enfermedad']);
    $dosis = mysqli_real_escape_string($conexion, $_POST['dosis']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $sql = "INSERT INTO vacunas (nombre_vacuna, enfermedad, dosis, fecha) 
            VALUES ('$vacuna', '$enfermedad', '$dosis', '$fecha')";
    if (mysqli_query($conexion, $sql)) {
        header("Location: ../vistas/vacunas.php?res=ok");
        exit();
    } else {
        echo "Error al insertar: " . mysqli_error($conexion);
    }
}
mysqli_close($conexion);
?>