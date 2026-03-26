<?php
session_start();
include '../database/db.php';
include '../modelos/usuarios.php'; // Importamos el modelo

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uModel = new Usuario($conexion);
    
    // Usamos los datos del POST directamente en la función del modelo
    $resultado = $uModel->actualizarDatos(
        $_POST['id_usuario'],
        $_POST['nombre'],
        $_POST['usuario'],
        $_POST['apellido_pat'],
        $_POST['apellido_mat'],
        $_POST['curp'],
        $_POST['fecha_nac']
    );

    if ($resultado) {
        // Actualizamos la sesión por si cambió el nombre de usuario
        $_SESSION['usuario'] = $_POST['usuario'];
        header("Location: ../vistas/home.php?update=success");
    } else {
        // En lugar de un echo, redirigimos con error para no romper la estética
        header("Location: ../vistas/editar_perfil.php?update=error");
    }
    exit();
}
?>