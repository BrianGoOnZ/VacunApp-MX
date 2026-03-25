<?php
include '../database/db.php'; // Traemos la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consulta para buscar al usuario
    // NOTA: Usamos la tabla 'usuarios' que creamos con SQL
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['usuario'] = $usuario;
        header("Location: ../vistas/home.php"); // Asegúrate de crear este archivo
    } else {
        // Datos incorrectos
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='../vistas/login.php';</script>";
    }
}
?>