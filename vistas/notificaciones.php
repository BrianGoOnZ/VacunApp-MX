<?php
$conn = new mysqli("localhost", "root", "abril123", "vacunapp");
if ($conn->connect_error) { die("Error: " . $conn->connect_error); }

$sql = "SELECT * FROM recordatorios ORDER BY fecha_recordatorio ASC";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>VacunApp MX - Notificaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- USANDO TU RUTA DE CSS -->
    <link rel="stylesheet" href="../Styles/style-notificaciones.css">
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
                        <li class="nav-item"><a href="notificaciones.php" class="nav-link active">Notificaciones</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-5">
        <section class="titulo-notificaciones">
            <h1>Notificaciones</h1>
        </section>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                
                <!-- CARD DE RECORDATORIOS (Usando tus clases de CSS) -->
                <article class="card-notificacion mb-4">
                    <div class="card-header-vapp d-flex justify-content-between align-items-center">
                        <span>Recordatorios</span>
                    </div>
                    <div class="card-body-vapp p-3">
                        <?php if ($resultado && $resultado->num_rows > 0): ?>
                            <?php while($fila = $resultado->fetch_assoc()): ?>
                                <div class="p-3 border-bottom mb-2 d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong style="color: #000291; display: block;"><?php echo htmlspecialchars($fila['titulo']); ?></strong>
                                        <p class="m-0 text-muted small"><?php echo htmlspecialchars($fila['descripcion']); ?></p>
                                        <small class="text-secondary"><?php echo date("d/m/Y", strtotime($fila['fecha_recordatorio'])); ?></small>
                                    </div>
                                    
                                    <!-- Tu botón de borrar con la clase .btn-close-vapp de tu CSS -->
                                    <a href="borrar_recordatorio.php?id=<?php echo $fila['id']; ?>" 
                                       class="btn-close-vapp text-decoration-none"
                                       onclick="return confirm('¿Eliminar recordatorio?')">✕</a>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="p-3 text-center text-muted">No tienes recordatorios pendientes.</p>
                        <?php endif; ?>
                    </div>
                </article>

            </div>
        </div>
    </main>
</body>
</html>