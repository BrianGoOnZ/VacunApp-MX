<?php
session_start();

// 1. Seguridad: Si no hay sesión, mandamos al index
if(!isset($_SESSION['usuario']) || !isset($_SESSION['id_usuario'])){ 
    header("Location: ../index.php"); 
    exit(); 
}

include '../database/db.php';
include '../modelos/Cita.php';
include '../modelos/recordatorios.php'; 

$citaModel = new Cita($conexion);
$recModel = new Recordatorio($conexion);

// 2. Obtenemos el ID del usuario logueado
$id_logueado = $_SESSION['id_usuario'];

// 3. Filtramos los eventos y la lista unificada por el ID del usuario
$eventos = $citaModel->obtenerEventosCombinadosPorUsuario($id_logueado);
$resTodo = $citaModel->listarTodoUnificadoPorUsuario($id_logueado);

// Lógica de fechas para el dibujo del calendario
$mes_actual = date('m');
$anio_actual = date('Y');
$primer_dia_mes = date('N', strtotime("$anio_actual-$mes_actual-01")); 
$ultimo_dia_mes = date('t', strtotime("$anio_actual-$mes_actual-01"));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VacunApp MX - Calendario Personalizado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style/style-index.css">
</head>
<body style="background-color: #f8f9fa;">
    <header>
        <?php include '../vistas/componentes/navbar.php'; ?>
    </header>

    <main class="container mt-5">
        <h2 class="titulo-seccion mb-4" style="color: #000291; font-weight: bold;">Gestión de Citas</h2>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <button class="btn p-3 shadow-sm text-white w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevo" style="background-color: #000291; border-radius: 12px; font-weight: bold;">
                    <i class="fas fa-calendar-plus me-2"></i>Nueva Cita
                </button>      
                
                <div class="card shadow-sm border-0 p-3" style="border-radius: 15px;">
                    <h6 class="fw-bold mb-3" style="color: #000291;">Mis Próximas Entradas</h6>
                    <div style="max-height: 480px; overflow-y: auto;">
                        <?php 
                        // El while ahora recorre solo los datos del usuario logueado
                        while($item = mysqli_fetch_assoc($resTodo)): 
                            $esRec = ($item['tipo'] == 'rec');
                            $icono = $esRec ? "🔔" : "💉";
                            $badgeClass = ($item['estado']=='completada'?'bg-success':($item['estado']=='perdida'?'bg-danger':'bg-warning text-dark'));
                            $urlEliminar = $esRec ? "../controladores/recordatorio_controller.php?eliminar=" : "../controladores/calendario_controller.php?eliminar=";
                        ?>
                        <div class="border-bottom mb-3 pb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small"><?php echo $icono; ?> <strong><?php echo htmlspecialchars($item['titulo']); ?></strong></span>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo strtoupper($item['estado']); ?></span>
                            </div>
                            <small class="text-muted d-block mt-1"><?php echo date("d/m/Y", strtotime($item['fecha'])); ?></small>
                            <div class="mt-2 d-flex gap-2">
                                <?php if(!$esRec): ?>
                                    <a href="../controladores/calendario_controller.php?id=<?php echo $item['id']; ?>&nuevo_estado=completada" class="btn btn-sm btn-outline-success"><i class="fas fa-check"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditarCita" data-id="<?php echo $item['id']; ?>" data-nombre="<?php echo $item['titulo']; ?>" data-fecha="<?php echo $item['fecha']; ?>"><i class="fas fa-edit"></i></a>
                                <?php endif; ?>
                                <a href="<?php echo $urlEliminar . $item['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-bordered text-center calendario-tabla bg-white mb-0">
                        <thead class="encabezado-tabla" style="background-color: #000291; color: white;">
                            <tr><th>LUN</th><th>MAR</th><th>MIE</th><th>JUE</th><th>VIE</th><th>SAB</th><th>DOM</th></tr>
                        </thead>
                        <tbody>
                            <?php
                            $dia_num = 1; $contador_celdas = 1;
                            for($i=0; $i<6; $i++){ 
                                echo "<tr>";
                                for($j=1; $j<=7; $j++){
                                    if(($contador_celdas < $primer_dia_mes) || ($dia_num > $ultimo_dia_mes)){
                                        echo "<td class='dia-vacio' style='background-color: #f1f1f1;'></td>";
                                    } else {
                                        $fecha_sql = "$anio_actual-$mes_actual-" . str_pad($dia_num, 2, "0", STR_PAD_LEFT);
                                        $clase_fondo = ($dia_num % 2 == 0) ? "dia-par" : "dia-impar";
                                        
                                        // Aquí se pintan los colores solo si la fecha existe para este usuario
                                        if(isset($eventos[$fecha_sql])){
                                            $e = $eventos[$fecha_sql];
                                            if($e == 'pendiente') $clase_fondo = "dia-pendiente";
                                            elseif($e == 'completada') $clase_fondo = "dia-completada";
                                            elseif($e == 'perdida') $clase_fondo = "dia-perdida";
                                        }
                                        echo "<td class='$clase_fondo' style='height: 80px; vertical-align: middle; font-weight: bold;'>$dia_num</td>";
                                        $dia_num++;
                                    }
                                    $contador_celdas++;
                                }
                                echo "</tr>";
                                if($dia_num > $ultimo_dia_mes) break;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modalNuevo" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="../controladores/calendario_controller.php" method="POST">
                <div class="modal-header text-white" style="background-color: #000291;">
                    <h5 class="modal-title">Nueva Cita</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre Vacuna</label>
                        <input type="text" name="nombre_vacuna" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Fecha</label>
                        <input type="date" name="fecha_vacuna" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="btn_guardar" class="btn text-white w-100" style="background-color: #000291;">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalEditarCita" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="../controladores/calendario_controller.php" method="POST">
                <div class="modal-header text-white" style="background-color: #0d6efd;">
                    <h5 class="modal-title">Editar Cita</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_editar" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre Vacuna</label>
                        <input type="text" name="nombre_vacuna" id="edit_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Fecha</label>
                        <input type="date" name="fecha_vacuna" id="edit_fecha" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="btn_editar" class="btn btn-primary w-100">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modalEditar = document.getElementById('modalEditarCita');
        if (modalEditar) {
            modalEditar.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                modalEditar.querySelector('#edit_id').value = button.getAttribute('data-id');
                modalEditar.querySelector('#edit_nombre').value = button.getAttribute('data-nombre');
                modalEditar.querySelector('#edit_fecha').value = button.getAttribute('data-fecha');
            });
        }
    </script>
</body>
</html>