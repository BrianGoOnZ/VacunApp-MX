<?php
require_once '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre       = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido_pat = mysqli_real_escape_string($conexion, $_POST['apellido_pat']);
    $curp         = mysqli_real_escape_string($conexion, $_POST['curp']);
    $fecha_nac    = mysqli_real_escape_string($conexion, $_POST['fecha_nac']);
    $usuario_name = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $correo       = mysqli_real_escape_string($conexion, $_POST['correo']);
    
    // GUARDAR DIRECTO SIN ENCRIPTAR
    $password_raw = mysqli_real_escape_string($conexion, $_POST['password']);
    $foto_default = 'default.png';

    $sql = "INSERT INTO usuarios (nombre, apellido_pat, curp, fecha_nac, usuario, correo, password, foto) 
            VALUES ('$nombre', '$apellido_pat', '$curp', '$fecha_nac', '$usuario_name', '$correo', '$password_raw', '$foto_default')";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ../index.php?msj=registro_exitoso");
        exit();
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}