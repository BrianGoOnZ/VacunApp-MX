<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - VacunApp MX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-5 text-center shadow">
            <h1>¡Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h1>
            <p>Has iniciado sesión correctamente en VacunApp MX.</p>
            <a href="../index.php" class="btn btn-primary">Ir al Inicio</a>
            <br>
            <a href="logout.php" class="text-danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>