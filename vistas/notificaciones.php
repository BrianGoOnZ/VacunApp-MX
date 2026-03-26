<?php
session_start();
include '../database/db.php';

// Ruta absoluta para evitar el error de "No such file"
$ruta_m = dirname(__DIR__) . '/modelos/recordatorios.php';

if (file_exists($ruta_m)) {
    include_once $ruta_m;
} else {
    die("Error Crítico: No se encontró el archivo físico en: " . $ruta_m);
}

$recordatorioModel = new Recordatorio($conexion);
$resultado = $recordatorioModel->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VacunApp MX - Notificaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style/style-index.css">
</head>
<body style="background-color: #f4f6fb;">

    <header class="vapp-navbar-main">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a href="../index.php" class="logo text-decoration-none">VacunApp <span class="mx">MX</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="../index.php" class="nav-link">Inicio</a></li>
                        <li class="nav-item"><a href="vacunas.php" class="nav-link">Vacunas</a></li>
                        <li class="nav-item"><a href="calendario.php" class="nav-link">Calendario</a></li>
                        <li class="nav-item"><a href="notificaciones.php" class="nav-link active">Notificaciones</a></li>
                        <li class="nav-item"><a href="centros.php" class="nav-link">Centros</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-5">
        <h2 class="titulo-seccion mb-4 text-center">Mis Notificaciones</h2>

        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                
                <div class="card-notificacion shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header-vapp d-flex justify-content-between align-items-center" style="background-color: #000291; color: white; padding: 15px;">
                        <span><i class="fas fa-bell me-2"></i>Avisos del Sistema</span>
                        <span class="badge bg-light text-dark">
                            <?php echo ($resultado) ? mysqli_num_rows($resultado) : 0; ?>
                        </span>
                    </div>

                    <div class="card-body p-0 bg-white">
                        <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                            <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
                                <div class="p-4 border-bottom d-flex justify-content-between align-items-center item-notificacion">
                                    <div>
                                        <strong style="color: #000291; font-size: 1.1rem;"><?php echo htmlspecialchars($fila['titulo']); ?></strong>
                                        <p class="mb-1 text-muted small"><?php echo htmlspecialchars($fila['descripcion']); ?></p>
                                        <small class="text-secondary fw-bold">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            <?php echo date("d/m/Y", strtotime($fila['fecha_recordatorio'])); ?>
                                        </small>
                                    </div>
                                    
                                    <a href="../controladores/notificaciones_controller.php?eliminar_id=<?php echo $fila['id']; ?>" 
                                       class="btn-delete-vapp text-decoration-none"
                                       style="color: #4ABEEF;"
                                       onclick="return confirm('¿Marcar como leída?')">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="py-5 text-center">
                                <i class="fas fa-check-double text-muted mb-3 fa-4x" style="color: #ced4da;"></i>
                                <p class="text-muted fw-bold">No tienes notificaciones pendientes.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>