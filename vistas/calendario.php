 <?php
// 1. CONEXIÓN
$conn = new mysqli("localhost", "root", "", "vacunapp");

// 2. LÓGICA CRUD
if (isset($_POST['btn_guardar'])) {
    $nombre = $_POST['nombre_vacuna'];
    $fecha = $_POST['fecha_vacuna'];
    $tipo = isset($_POST['es_recordatorio']) ? 1 : 0;
    $conn->query("INSERT INTO citas (nombre_vacuna, fecha, es_recordatorio) VALUES ('$nombre', '$fecha', '$tipo')");
    header("Location: calendario.php");
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM citas WHERE id = $id");
    header("Location: calendario.php");
}

if (isset($_GET['id']) && isset($_GET['nuevo_estado'])) {
    $id = $_GET['id'];
    $est = $_GET['nuevo_estado'];
    $conn->query("UPDATE citas SET estado = '$est' WHERE id = $id");
    header("Location: calendario.php");
}

// Obtener eventos para el calendario
$res = $conn->query("SELECT fecha, estado FROM citas");
$eventos = [];
while($r = $res->fetch_assoc()) { $eventos[$r['fecha']] = $r['estado']; }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VacunApp MX - Calendario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* TU ESTILO ORIGINAL */
        .vapp-navbar-main { background-color: #000291; padding: 10px 0; }
        .logo { color: #f2f2f2; font-size: 1.8em; font-weight: bold; text-decoration: none; }
        .mx { color: #4ABEEF; }
        body { background-color: #f4f6fb; font-family: Arial, sans-serif; }
        .titulo { color: #000291; font-weight: bold; text-align: center; text-transform: uppercase; margin-top: 20px; }
        .titulo::after { content: ""; display: block; width: 100px; height: 4px; background-color: #4ABEEF; margin: 10px auto; border-radius: 2px; }
        
        /* TABLA Y COLORES */
        .calendario-tabla td { height: 75px; vertical-align: middle; font-weight: bold; border: 1px solid #dee2e6; }
        .encabezado { background-color: #000291 !important; color: white !important; }
        .dia { background-color: #000291 !important; color: white !important; }
        .dia-claro { background-color: #93c5fd !important; color: #000291 !important; }
        
        /* ESTADOS DINÁMICOS */
        .dia-pendiente { background-color: #ffeb3b !important; color: black !important; border: 3px solid #fbc02d !important; }
        .dia-completada { background-color: #4caf50 !important; color: white !important; border: 3px solid #2e7d32 !important; }
        .dia-perdida { background-color: #f44336 !important; color: white !important; border: 3px solid #c62828 !important; }

        .btn-azul { background: linear-gradient(to right, #000291, #1f4fa3) !important; color: white !important; font-weight: bold; border: none; padding: 10px; border-radius: 8px; }
        .card-gestion { border-radius: 15px; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1); background: white; }
    </style>
</head>
<body>

    <header class="vapp-navbar-main">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="#" class="logo">VacunApp <span class="mx">MX</span></a>
            <div class="text-white small">Sesión: Administrador</div>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="titulo">Calendario</h2>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <button class="btn btn-azul w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevo">
                    + Añadir Cita o Recordatorio
                </button>
                
                <div class="card card-gestion p-3">
                    <h6 class="fw-bold text-primary mb-3">Gestión de Citas</h6>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <?php
                        $lista = $conn->query("SELECT * FROM citas ORDER BY fecha ASC");
                        while($c = $lista->fetch_assoc()):
                            $icono = $c['es_recordatorio'] ? "🔔" : "💉";
                        ?>
                        <div class="border-bottom mb-2 pb-2">
                            <div class="d-flex justify-content-between">
                                <span><?php echo $icono; ?> <strong><?php echo $c['nombre_vacuna']; ?></strong></span>
                                <small class="badge bg-light text-dark border"><?php echo $c['estado']; ?></small>
                            </div>
                            <small class="text-muted d-block"><?php echo date("d/m/Y", strtotime($c['fecha'])); ?></small>
                            <div class="mt-2">
                                <a href="?id=<?php echo $c['id']; ?>&nuevo_estado=completada" class="btn btn-sm btn-success">✓</a>
                                <a href="?id=<?php echo $c['id']; ?>&nuevo_estado=perdida" class="btn btn-sm btn-warning">⚠</a>
                                <a href="?eliminar=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Borrar?')">🗑</a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="table-responsive shadow-sm">
                    <table class="table table-bordered text-center calendario-tabla">
                        <thead class="encabezado">
                            <tr><th>L</th><th>M</th><th>M</th><th>J</th><th>V</th><th>S</th><th>D</th></tr>
                        </thead>
                        <tbody>
                            <?php
                            $dia_num = 1;
                            for($i=0; $i<5; $i++){
                                echo "<tr>";
                                for($j=0; $j<7; $j++){
                                    if($dia_num <= 31){
                                        $fecha_sql = "2026-03-" . str_pad($dia_num, 2, "0", STR_PAD_LEFT);
                                        
                                        // Estilo por defecto (el que tenías)
                                        $estilo = ($dia_num % 2 == 0) ? "dia-claro" : "dia";
                                        
                                        // Si hay cita, aplicamos color de estado
                                        if(isset($eventos[$fecha_sql])){
                                            $e = $eventos[$fecha_sql];
                                            if($e == 'pendiente') $estilo = "dia-pendiente";
                                            elseif($e == 'completada') $estilo = "dia-completada";
                                            elseif($e == 'perdida') $estilo = "dia-perdida";
                                        }

                                        echo "<td class='$estilo'>$dia_num</td>";
                                        $dia_num++;
                                    } else {
                                        echo "<td class='bg-light'></td>";
                                    }
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNuevo" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST">
                <div class="modal-header bg-vapp text-white">
                    <h5 class="modal-title">Agendar Entrada</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre de Vacuna / Recordatorio</label>
                        <input type="text" name="nombre_vacuna" class="form-control" placeholder="Ej: Refuerzo COVID" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha_vacuna" class="form-control" required>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" name="es_recordatorio" id="sw">
                        <label class="form-check-label" for="sw">Marcar como Recordatorio (Campana)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btn_guardar" class="btn btn-azul w-100">Guardar en Sistema</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>