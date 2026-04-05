<?php
session_start();
if(!isset($_SESSION['usuario'])){ header("Location: ../index.php"); exit(); }

include '../database/db.php';
include '../modelos/cita.php'; 

$citaModel = new Cita($conexion);
$id_logueado = $_SESSION['id_usuario'];

// IMPORTANTE: Ahora la consulta solo debe traer los que NO han sido leídos
$resUnificado = $citaModel->listarNotificacionesActivas($id_logueado);
$total = ($resUnificado) ? mysqli_num_rows($resUnificado) : 0;
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
    <header><?php include '../vistas/componentes/navbar.php'; ?></header>

    <main class="container py-5">
        <h2 class="text-center mb-4" style="color: #000291; font-weight: bold; letter-spacing: 2px;">MIS NOTIFICACIONES</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-8">    
                <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                    <div class="d-flex justify-content-between align-items-center p-3" style="background-color: #000291; color: white;">
                        <span class="fw-bold"><i class="fas fa-bell me-2"></i>AVISOS DEL SISTEMA</span>
                        <span class="badge rounded-pill bg-white text-dark"><?php echo $total; ?></span>
                    </div>

                    <div class="card-body bg-white p-0">
                        <?php if ($total > 0): ?>
                            <?php while($fila = mysqli_fetch_assoc($resUnificado)): ?>
                                <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="me-4">
                                            <i class="fas fa-calendar-check fa-3x" style="color: #4ABEEF;"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1" style="color: #000291; font-weight: bold;"><?php echo htmlspecialchars($fila['titulo']); ?></h5>
                                            <p class="mb-1 text-muted">Tienes una cita de vacunación programada (Estado: Pendiente).</p>
                                            <div class="text-secondary small fw-bold">
                                                <i class="fas fa-calendar-alt me-1"></i> <?php echo date("d/m/Y", strtotime($fila['fecha'])); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ms-2">
                                        <a href="../controladores/cita_controller.php?ocultar_aviso=<?php echo $fila['id']; ?>" 
                                           class="btn btn-link text-secondary p-0" style="font-size: 1.5rem; text-decoration: none;">
                                            <i class="fas fa-times-circle opacity-25"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="py-5 text-center">
                                <i class="fas fa-check-double mb-3 fa-4x" style="color: #dee2e6;"></i>
                                <p class="text-muted fw-bold">No tienes notificaciones pendientes.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>