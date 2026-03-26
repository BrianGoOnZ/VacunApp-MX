<?php
session_start();
include '../database/db.php';
include '../modelos/usuarios.php'; 
if(!isset($_SESSION['usuario'])){
    header("Location: ../index.php");
    exit();
}
$usuarioModel = new Usuario($conexion);
$datos = $usuarioModel->obtenerPerfil($_SESSION['usuario']);
if (!$datos) { header("Location: ../index.php"); exit(); }
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

    <header>
        <?php include('componentes/navbar.php')?>
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