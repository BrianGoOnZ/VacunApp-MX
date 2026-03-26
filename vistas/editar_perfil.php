<?php
session_start();
include '../database/db.php';

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
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
    <title>Editar Perfil - VacunApp MX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/style-index.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow p-4" style="max-width: 600px; margin: auto; border-radius: 15px;">
            <h2 class="text-center mb-4" style="color: #001a57;">Editar Mis Datos</h2>
            
            <form action="../controladores/actualizar_proceso.php" method="POST">
                <input type="hidden" name="id_usuario" value="<?php echo $datos['id_usuario']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo $datos['nombre']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Usuario</label>
                        <input type="text" name="usuario" class="form-control" value="<?php echo $datos['usuario']; ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Apellido Paterno</label>
                        <input type="text" name="apellido_pat" class="form-control" value="<?php echo $datos['apellido_pat']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Apellido Materno</label>
                        <input type="text" name="apellido_mat" class="form-control" value="<?php echo $datos['apellido_mat']; ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">CURP</label>
                    <input type="text" name="curp" class="form-control" value="<?php echo $datos['curp']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Nacimiento</label>
                    <?php 
                        $fecha_formateada = date("Y-m-d", strtotime($datos['fecha_nac'])); 
                    ?>
                    <input type="date" name="fecha_nac" class="form-control" value="<?php echo $fecha_formateada; ?>" required>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-warning fw-bold text-dark">Guardar Cambios</button>
                    <a href="home.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>