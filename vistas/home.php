<?php
session_start();
include '../database/db.php';

if(!isset($_SESSION['usuario'])){
    header("Location: ../index.php");
    exit();
}

$user_session = $_SESSION['usuario'];
$query = "SELECT * FROM usuarios WHERE usuario = '$user_session'";
$res = mysqli_query($conexion, $query);
$datos = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - VacunApp MX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/style-index.css">
</head>
<body class="bg-light">
    <?php include('componentes/navbar.php')?>
    <div class="container mt-5">
        <div class="card shadow border-0 rounded-4 mx-auto p-4 text-center" style="max-width: 500px;">
            <h2 class="mb-4 fw-bold" style="color: #001a57;">Mi Perfil</h2>
            
            <img src="../<?php echo $datos['foto']; ?>" class="rounded-circle mb-4 mx-auto" 
                 style="width: 160px; height: 160px; object-fit: cover; border: 4px solid #001a57;">

            <div class="text-start mb-4 px-3">
                <p class="mb-1 text-muted small text-uppercase fw-bold">Nombre Completo</p>
                <p class="mb-3 fs-5"><?php echo $datos['nombre'] . " " . $datos['apellido_pat'] . " " . $datos['apellido_mat']; ?></p>
                
                <p class="mb-1 text-muted small text-uppercase fw-bold">CURP</p>
                <p class="mb-3 fs-5"><?php echo $datos['curp']; ?></p>
                
                <p class="mb-1 text-muted small text-uppercase fw-bold">Nombre de Usuario</p>
                <p class="mb-3 fs-5"><?php echo $datos['usuario']; ?></p>
            </div>

            <div class="d-grid gap-2">
                <a href="editar_perfil.php" class="btn py-2 fw-bold" style="background-color: #001a57; color: white;">Editar Mis Datos</a>
                <a href="../index.php" class="btn btn-outline-secondary py-2">Volver al Inicio</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>