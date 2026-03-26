<?php
// 1. CONEXIÓN A LA BASE DE DATOS
$conn = new mysqli("localhost", "root", "abril123", "vacunapp");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 2. CONSULTAR RECORDATORIOS
$sql = "SELECT * FROM recordatorios ORDER BY fecha_recordatorio ASC";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VacunApp MX - Notificaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="Styles/style-notificaciones.css">
</head>
<body>
    <header class="vapp-navbar-main">
        <nav class="navbar navbar-expand-lg navbar-dark container">
            <div class="container-fluid">
                <a href="index.php" class="logo text-decoration-none">
                    VacunApp <span class="mx">MX</span>
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                        <li class="nav-item"><a href="vacunas.php" class="nav-link">Vacunas</a></li>
                        <li class="nav-item"><a href="calendario.php" class="nav-link">Calendario</a></li>
                        <li class="nav-item"><a href="notificaciones.php" class="nav-link active">Notificaciones</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-5">
        <section class="titulo-notificaciones mb-4">
            <h1>Notificaciones</h1>
        </section>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                
                <!-- CARD DINÁMICA DE RECORDATORIOS -->
                <article class="card-notificacion mb-4">
                    <div class="card-header-vapp d-flex justify-content-between align-items-center">
                        <span>Recordatorios</span>
                    </div>
                    <div class="card-body-vapp p-3">
                        <?php if ($resultado && $resultado->num_rows > 0): ?>
                            <?php while($fila = $resultado->fetch_assoc()): ?>
                                <div class="p-2 border-bottom mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong style="color: #000291;"><?php echo htmlspecialchars($fila['titulo']); ?></strong>
                                        
                                        <!-- BOTÓN BORRAR REAL -->
                                        <a href="borrar_recordatorio.php?id=<?php echo $fila['id']; ?>" 
                                           class="btn-close-vapp text-decoration-none" 
                                           style="color: #000291; font-weight: bold;"
                                           onclick="return confirm('¿Eliminar este recordatorio?')">
                                           ✕
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="m-0 text-muted small"><?php echo htmlspecialchars($fila['descripcion']); ?></p>
                                        <small class="text-muted"><?php echo date("d/m/Y", strtotime($fila['fecha_recordatorio'])); ?></small>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="m-0 text-muted">No tienes recordatorios pendientes.</p>
                        <?php endif; ?>
                    </div>
                </article>

                <!-- CARD ESTÁTICA: MENSAJES -->
                <article class="card-notificacion mb-4">
                    <div class="card-header-vapp d-flex justify-content-between align-items-center">
                        <span>Mensajes</span>
                    </div>
                    <div class="card-body-vapp p-3">
                        <p class="m-0 text-muted">Tienes un mensaje del sector salud.</p>
                    </div>
                </article>

            </div>
        </div>
    </main>

    <?php $conn->close(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>