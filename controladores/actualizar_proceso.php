<?php
session_start();
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibimos los datos del formulario
    $id = $_POST['id_usuario'];
    $nom = $_POST['nombre'];
    $ape_p = $_POST['apellido_pat'];
    $ape_m = $_POST['apellido_mat'];
    $curp = $_POST['curp'];
    $f_nac = $_POST['fecha_nac'];
    $user = $_POST['usuario'];

    // Consulta para actualizar la tabla usuarios
// ... después de recibir los datos del POST ...

    $sql = "UPDATE usuarios SET 
            nombre = '$nom', 
            apellido_pat = '$ape_p', 
            apellido_mat = '$ape_m', 
            curp = '$curp', 
            fecha_nac = '$f_nac', 
            usuario = '$user' 
            WHERE id_usuario = $id";

    if(mysqli_query($conexion, $sql)){
        // Actualizamos la sesión por si cambió el nombre de usuario
        $_SESSION['usuario'] = $user; 
        header("Location: ../vistas/home.php?update=success");
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>