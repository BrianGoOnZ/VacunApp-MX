<?php
session_start();
include '../database/db.php';
include '../modelos/usuarios.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uModel = new Usuario($conexion);
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
        $_SESSION['usuario'] = $_POST['usuario'];
        header("Location: ../vistas/home.php?update=success");
    } else {
        header("Location: ../vistas/editar_perfil.php?update=error");
    }
    exit();
}
?>