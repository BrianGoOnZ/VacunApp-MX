<?php
// 1. CONEXIÓN A LA BASE DE DATOS
$conn = new mysqli("localhost", "root", "abril123", "vacunapp");

// Verificar conexión
if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}

// 2. LÓGICA CRUD (INSERTAR)
if (isset($_POST['btn_guardar_vacuna'])) {
    $nombre = $_POST['nombre_vacuna'];
    $enfermedad = $_POST['enfermedad'];
    $dosis = $_POST['dosis'];
    $fecha = $_POST['fecha'];
    $frecuencia = $_POST['frecuencia'];

    $sql = "INSERT INTO vacunas (nombre_vacuna, enfermedad, dosis, frecuencia, fecha) 
            VALUES ('$nombre', '$enfermedad', '$dosis', '$frecuencia', '$fecha')";
    
    if ($conn->query($sql)) {
        header("Location: vacunas.php");
    }
}

// LÓGICA CRUD (ELIMINAR)
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM vacunas WHERE id = $id");
    header("Location: vacunas.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VacunApp MX - Mis Vacunas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* ESTILOS DE TU MARCA */
        .vapp-navbar-main { background-color: #000291; padding: 10px 0; }
        .logo { color: #f2f2f2; font-size: 1.8em; font-weight: bold; text-decoration: none; }
        .mx { color: #4ABEEF; }
        body { background-color: #f4f6fb; font-family: Arial, sans-serif; }
        
        .titulo { color: #000291; font-weight: bold; text-align: center; text-transform: uppercase; margin-top: 20px; }
        .titulo::after { content: ""; display: block; width: 100px; height: 4px; background-color: #4ABEEF; margin: 10px auto; border-radius: 2px; }

        /* TABLA ESTILO CARTILLA */
        .tabla-vacunas { background: white; border-radius: 10px; overflow: hidden; border: 2px solid #dee2e6; }
        .tabla-vacunas thead { background-color: #7297c1 !important; color: white; }
        .tabla-vacunas th { padding: 15px; border: 1px solid #dee2e6; text-transform: uppercase; font-size: 0.85rem; }
        .tabla-vacunas td { vertical-align: middle; border: 1px solid #dee2e6; height: 60px; }
        
        /* Columna azul claro lateral */
        .col-azul-claro { background-color: #93c5fd !important; color: #000291 !important; font-weight: bold; width: 20%; }

        .btn-azul { background: linear-gradient(to right, #000291, #1f4fa3) !important; color: white !important; font-weight: bold; border: none; padding: 12px; border-radius: 10px; box-shadow: 0 4px 0 #000150; }
        .btn-azul:active { transform: translateY(3px); box-shadow: none; }
        
        .modal-vapp { border: 3px solid #000291; border-radius: 20px; }
    </style>
</head>
<body>

    <header class="vapp-navbar-main shadow">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" class="logo">VacunApp <span class="mx">MX</span></a>
            <nav>
                <a href="index.php" class="text-white text-decoration-none me-3">Inicio</a>
                <a href="vacunas.php" class="text-white text-decoration-none fw-bold">Vacunas</a>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="titulo">Mis Vacunas</h2>
        
        <div class="row mt-5">
            <!-- COLUMNA IZQUIERDA: ACCIONES -->
            <div class="col-md-3">
                <button class="btn btn-azul w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalVacuna">
                    + Añadir Vacuna
                </button>
                <div class="card p-3 shadow-sm border-0" style="border-radius: 15px;">
                    <small class="text-muted">Gestión rápida:</small>
                    <hr>
                    <p class="small text-secondary">Registra tus dosis aplicadas para mantener tu historial al día.</p>
                </div>
            </div>

            <!-- COLUMNA DERECHA: TABLA -->
            <div class="col-md-9">
                <div class="table-responsive shadow-sm">
                    <table class="table table-bordered text-center tabla-vacunas">
                        <thead>
                            <tr>
                                <th>Vacuna</th>
                                <th>Enfermedad</th>
                                <th>Dosis</th>
                                <th>Edad/Frecuencia</th>
                                <th>Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = $conn->query("SELECT * FROM vacunas ORDER BY fecha DESC");
                            if ($res->num_rows > 0) {
                                while($v = $res->fetch_assoc()): ?>
                                    <tr>
                                        <td class="col-azul-claro"><?php echo $v['nombre_vacuna']; ?></td>
                                        <td><?php echo $v['enfermedad']; ?></td>
                                        <td><?php echo $v['dosis']; ?></td>
                                        <td><?php echo $v['frecuencia']; ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($v['fecha'])); ?></td>
                                        <td>
                                            <a href="?eliminar=<?php echo $v['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Borrar registro?')">🗑</a>
                                        </td>
                                    </tr>
                                <?php endwhile;
                            } else {
                                // Filas vacías para diseño
                                for($i=0; $i<5; $i++) {
                                    echo "<tr><td class='col-azul-claro'></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA REGISTRAR -->
    <div class="modal fade" id="modalVacuna" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content modal-vapp" method="POST">
                <div class="modal-header text-white" style="background-color: #000291;">
                    <h5 class="modal-title">Registrar Nueva Vacuna</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre de la Vacuna</label>
                        <input type="text" name="nombre_vacuna" class="form-control" placeholder="Ej: Influenza" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Enfermedad que previene</label>
                        <input type="text" name="enfermedad" class="form-control" placeholder="Ej: Gripe estacional">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Dosis</label>
                            <input type="text" name="dosis" class="form-control" placeholder="1ra, Única, etc.">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Frecuencia</label>
                            <input type="text" name="frecuencia" class="form-control" placeholder="Anual, 6 meses...">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Fecha de Aplicación</label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" name="btn_guardar_vacuna" class="btn btn-azul w-100">Guardar en mi Cartilla</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>