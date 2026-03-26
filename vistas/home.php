<?php
session_start();
include '../database/db.php';

// Si no hay sesión, mandarlo al login
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

// Consultar los datos completos del usuario logueado
$user_session = $_SESSION['usuario'];
$query = "SELECT * FROM usuarios WHERE usuario = '$user_session'";
$resultado = mysqli_query($conexion, $query);
$datos = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mi Perfil - VacunApp MX</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../style/style-index.css">
    </head>
    <body>
        <div class="container mt-5">
            <div class="card shadow p-4 text-center" style="max-width: 500px; margin: auto; border-radius: 15px;">
                <h2 class="mb-4" style="color: #001a57;">Mi Perfil</h2>
                
                <img src="../<?php echo $datos['foto']; ?>" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #001a57;">
                
                <div class="text-start">
                    <p><strong>Nombre:</strong> <?php echo $datos['nombre'] . " " . $datos['apellido_pat']; ?></p>
                    <p><strong>CURP:</strong> <?php echo $datos['curp']; ?></p>
                    <p><strong>Usuario:</strong> <?php echo $datos['usuario']; ?></p>
                </div>

                <hr>
                <a href="editar_perfil.php" class="btn btn-warning w-100 mb-2">Editar Mis Datos</a>
                <a href="../index.php" class="btn btn-secondary w-100">Volver al Inicio</a>
            </div>
        </div>
    </body>
</html>