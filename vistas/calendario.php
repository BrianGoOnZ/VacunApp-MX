<?php
session_start();
include '../database/db.php';
include '../modelos/Cita.php';
$citaModel = new Cita($conexion);
$eventos = $citaModel->obtenerEventos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VacunApp MX - Calendario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style/style-index.css">
</head>
<body>

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
                        <li class="nav-item"><a href="calendario.php" class="nav-link active">Calendario</a></li>
                        <li class="nav-item"><a href="notificaciones.php" class="nav-link">Notificaciones</a></li>
                        <li class="nav-item"><a href="centros.php" class="nav-link">Centros</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <h2 class="titulo-seccion mb-4">Calendario de Citas</h2>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <button class="btn-iniciarsesion w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevo">
                    <i class="fas fa-calendar-plus me-2"></i>Nueva Cita
                </button>
                
                <div class="card shadow-sm border-0 p-3" style="border-radius: 15px;">
                    <h6 class="fw-bold mb-3" style="color: #000291;">Próximas Entradas</h6>
                    <div style="max-height: 480px; overflow-y: auto;">
                        <?php
                        $lista = $citaModel->listar();
                        if ($lista && mysqli_num_rows($lista) > 0) {
                            while($c = mysqli_fetch_assoc($lista)):
                                $icono = $c['es_recordatorio'] ? "🔔" : "💉";
                                $badgeClass = ($c['estado']=='completada'?'bg-success':($c['estado']=='perdida'?'bg-danger':'bg-warning text-dark'));
                        ?>
                        <div class="border-bottom mb-3 pb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small"><?php echo $icono; ?> <strong><?php echo htmlspecialchars($c['nombre_vacuna']); ?></strong></span>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo strtoupper($c['estado']); ?></span>
                            </div>
                            <small class="text-muted d-block mt-1"><?php echo date("d/m/Y", strtotime($c['fecha'])); ?></small>
                            <div class="mt-2 d-flex gap-2">
                                <a href="../controladores/calendario_controller.php?id=<?php echo $c['id']; ?>&nuevo_estado=completada" class="btn btn-sm btn-outline-success"><i class="fas fa-check"></i></a>
                                <a href="../controladores/calendario_controller.php?id=<?php echo $c['id']; ?>&nuevo_estado=perdida" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></a>
                                <a href="../controladores/calendario_controller.php?eliminar=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-secondary" onclick="return confirm('¿Eliminar cita?')"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                        <?php endwhile; 
                        } else { echo "<p class='text-muted small'>No hay citas programadas.</p>"; } ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-bordered text-center calendario-tabla bg-white mb-0">
                        <thead class="encabezado-tabla">
                            <tr><th>LUN</th><th>MAR</th><th>MIE</th><th>JUE</th><th>VIE</th><th>SAB</th><th>DOM</th></tr>
                        </thead>
                        <tbody>
                            <?php
                            $dia_num = 1;
                            for($i=0; $i<5; $i++){
                                echo "<tr>";
                                for($j=0; $j<7; $j++){
                                    if($dia_num <= 31){
                                        $fecha_sql = "2026-03-" . str_pad($dia_num, 2, "0", STR_PAD_LEFT);
                                        $clase_fondo = ($dia_num % 2 == 0) ? "dia-par" : "dia-impar";
                                        
                                        if(isset($eventos[$fecha_sql])){
                                            $e = $eventos[$fecha_sql];
                                            if($e == 'pendiente') $clase_fondo = "dia-pendiente";
                                            elseif($e == 'completada') $clase_fondo = "dia-completada";
                                            elseif($e == 'perdida') $clase_fondo = "dia-perdida";
                                        }

                                        echo "<td class='$clase_fondo'>$dia_num</td>";
                                        $dia_num++;
                                    } else {
                                        echo "<td class='dia-vacio'></td>";
                                    }
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-center gap-4 leyenda-contenedor shadow-sm">
                    <small><i class="fas fa-circle text-warning"></i> Pendiente</small>
                    <small><i class="fas fa-circle text-success"></i> Completada</small>
                    <small><i class="fas fa-circle text-danger"></i> Perdida</small>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade modal-vapp" id="modalNuevo" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="../controladores/calendario_controller.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-calendar-plus me-2"></i>AGENDAR CITA</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre de Vacuna / Nota</label>
                        <input type="text" name="nombre_vacuna" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha Programada</label>
                        <input type="date" name="fecha_vacuna" class="form-control" required>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" name="es_recordatorio" id="sw">
                        <label class="form-check-label" for="sw">Activar Recordatorio (Notificación)</label>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="btn_guardar" class="btn-iniciarsesion w-100">Guardar en Calendario</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>