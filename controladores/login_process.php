<?php
include '../database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapamos los datos para evitar errores con comillas
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    // Buscamos al usuario en la tabla
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        // EXTRAEMOS los datos de la fila encontrada
        $datos = mysqli_fetch_assoc($resultado);

        session_start();
        // Guardamos el nombre (lo que ya tenías)
        $_SESSION['usuario'] = $datos['usuario'];
        
        // ESTO ES LO QUE FALTABA: Guardar el ID de la tabla
        // Revisa que en tu tabla se llame 'id_usuario' exactamente
        $_SESSION['id_usuario'] = $datos['id_usuario']; 

        header("Location: ../vistas/home.php");
        exit();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='../vistas/login.php';</script>";
    }
}
?>