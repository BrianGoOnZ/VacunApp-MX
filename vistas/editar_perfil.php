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

// Formatear la fecha para que el input date la reconozca (AAAA-MM-DD)
$fecha_formateada = date("Y-m-d", strtotime($datos['fecha_nac'])); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - VacunApp MX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/style-index.css">
</head>
<body class="bg-light">

    <header class="vapp-navbar-main">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a href="../index.php" class="logo text-decoration-none">
                    VacunApp <span class="mx">MX</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="../index.php" class="nav-link">Inicio</a></li>
                        <li class="nav-item"><a href="vacunas.html" class="nav-link">Vacunas</a></li>
                        <li class="nav-item"><a href="calendario.html" class="nav-link">Calendario</a></li>
                        <li class="nav-item"><a href="notificaciones.html" class="nav-link">Notificaciones</a></li>
                        <li class="nav-item"><a href="centros.html" class="nav-link">Centros</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5 mb-5">
        <div class="card shadow border-0 rounded-4 mx-auto p-4" style="max-width: 600px;">
            <h2 class="text-center mb-4 fw-bold" style="color: #001a57;">Editar Mis Datos</h2>
            
            <form action="../controladores/actualizar_proceso.php" method="POST">
                <input type="hidden" name="id_usuario" value="<?php echo $datos['id_usuario']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo $datos['nombre']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Usuario</label>
                        <input type="text" name="usuario" class="form-control" value="<?php echo $datos['usuario']; ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Apellido Paterno</label>
                        <input type="text" name="apellido_pat" class="form-control" value="<?php echo $datos['apellido_pat']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Apellido Materno</label>
                        <input type="text" name="apellido_mat" class="form-control" value="<?php echo $datos['apellido_mat']; ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">CURP</label>
                    <input type="text" name="curp" class="form-control text-uppercase" value="<?php echo $datos['curp']; ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted text-uppercase">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nac" class="form-control" value="<?php echo $fecha_formateada; ?>" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn py-2 fw-bold" style="background-color: #001a57; color: white;">
                        GUARDAR CAMBIOS
                    </button>
                    <a href="home.php" class="btn btn-secondary py-2">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>