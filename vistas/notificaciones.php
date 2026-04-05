<?php
session_start();
// Seguridad: Si no hay sesión, al index
if(!isset($_SESSION['usuario'])){ header("Location: ../index.php"); exit(); }

include '../database/db.php';
include '../modelos/recordatorios.php';

$recModel = new Recordatorio($conexion);
$id_logueado = $_SESSION['id_usuario']; 

// Aquí definimos $resR
$resR = $recModel->listarPorUsuario($id_logueado); 
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
    <header>
        <?php include '../vistas/componentes/navbar.php'; ?>
    </header>
    <main class="container py-5">
        <h2 class="titulo-seccion mb-4 text-center">Mis Notificaciones</h2>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">    
                <div class="card-notificacion shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header-vapp d-flex justify-content-between align-items-center" style="background-color: #000291; color: white; padding: 15px;">
                        <span><i class="fas fa-bell me-2"></i>Avisos del Sistema</span>
                        <span class="badge bg-light text-dark">
                            <?php echo ($resR) ? mysqli_num_rows($resR) : 0; ?>
                        </span>
                    </div>
                    <div class="card-body p-0 bg-white">
                        <?php 
                        // CAMBIADO: Usamos $resR y validamos que no sea false
                        if ($resR && mysqli_num_rows($resR) > 0): ?>
                            <?php while($fila = mysqli_fetch_assoc($resR)): ?>
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