<?php
include '../database/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
    $resultado = mysqli_query($conexion, $query);
    if (mysqli_num_rows($resultado) > 0) {
        session_start();
        $_SESSION['usuario'] = $usuario;
        header("Location: ../vistas/home.php");
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='../vistas/login.php';</script>";
    }
}
?>