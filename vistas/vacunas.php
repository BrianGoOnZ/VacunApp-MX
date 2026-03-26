<?php
// CONEXIÓN (ajústala a tu BD)
$conexion = mysqli_connect("localhost", "root", "", "vacunapp");

if (!$conexion) {
    die("Error de conexión");
}

// CONSULTA
$resultado = mysqli_query($conexion, "SELECT * FROM vacunas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VacunApp MX - Mis Vacunas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/style-index.css">
    <link rel="stylesheet" href="Styles/disvacunas.css">
</head>

<body>

<header class="vapp-navbar-main">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a href="index.php" class="logo text-decoration-none">
                VacunApp <span class="mx">MX</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                    <li class="nav-item"><a href="vacunas.php" class="nav-link active">Vacunas</a></li>
                    <li class="nav-item"><a href="calendario.php" class="nav-link">Calendario</a></li>
                    <li class="nav-item"><a href="notificaciones.php" class="nav-link">Notificaciones</a></li>
                    <li class="nav-item"><a href="centros.php" class="nav-link">Centros</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
    <div class="bienvenida text-center mt-4">MIS VACUNAS</div>  

    <div class="container mt-5">
        <div class="row">        

            <div class="col-md-3 mb-4">
                <div class="d-grid gap-3">
                    <button class="btn-iniciarsesion" data-bs-toggle="modal" data-bs-target="#modalAgregarVacuna">
                        + Añadir vacuna
                    </button>

                    <button class="btn-iniciarsesion" data-bs-toggle="modal" data-bs-target="#modalRecordatorio">
                        + Recordatorio
                    </button>
                </div>
            </div>

            <div class="col-md-9">
                <div class="table-responsive shadow-sm">
                    <table class="tabla-vapp">
                        <thead>
                            <tr>
                                <th class="col-azul-claro">Vacuna</th>
                                <th>ENFERMEDAD QUE PREVIENE</th>
                                <th>DOSIS</th>
                                <th>EDAD Y FRECUENCIA</th>
                                <th>FECHA</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php while($fila = mysqli_fetch_assoc($resultado)) { ?>
                            <tr>
                                <td class="col-azul-claro"><?php echo $fila['vacuna']; ?></td>
                                <td><?php echo $fila['enfermedad']; ?></td>
                                <td><?php echo $fila['dosis']; ?></td>
                                <td><?php echo $fila['edad']; ?></td>
                                <td><?php echo $fila['fecha']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- MODAL VACUNA -->
<div class="modal fade" id="modalAgregarVacuna">
    <div class="modal-dialog">
        <div class="modal-content modal-vapp">

            <div class="modal-header">
                <h5 class="modal-title">NUEVA VACUNA</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="guardar_vacuna.php">

                    <div class="mb-3">
                        <label class="form-label">Nombre de la Vacuna:</label>
                        <input type="text" name="vacuna" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Enfermedad:</label>
                        <input type="text" name="enfermedad" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Dosis:</label>
                            <input type="text" name="dosis" class="form-control">
                        </div>

                        <div class="col-6 mb-3">
                            <label class="form-label">Fecha:</label>
                            <input type="date" name="fecha" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn-iniciarsesion w-100 mt-2">
                        Guardar Vacuna
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- MODAL RECORDATORIO -->
<div class="modal fade" id="modalRecordatorio">
    <div class="modal-dialog">
        <div class="modal-content modal-vapp">

            <div class="modal-header">
                <h5 class="modal-title">NUEVO RECORDATORIO</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="guardar_recordatorio.php">

                    <div class="mb-3">
                        <label class="form-label">Título:</label>
                        <input type="text" name="titulo" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha del recordatorio:</label>
                        <input type="date" name="fecha" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nota adicional:</label>
                        <textarea name="nota" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn-iniciarsesion w-100 mt-2">
                        Crear Recordatorio
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>