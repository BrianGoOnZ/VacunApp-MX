<?php
$directorio_actual = basename(dirname($_SERVER['PHP_SELF']));
if ($directorio_actual == 'vistas') {
    $path = "";
    $inicio = "../index.php";
} else {
    $path = "vistas/";
    $inicio = "index.php";
}
?>
<header class="vapp-navbar-main">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a href="<?php echo $inicio; ?>" class="logo text-decoration-none">
                VacunApp <span class="mx">MX</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="<?php echo $inicio; ?>" class="nav-link">Inicio</a></li>
                    <li class="nav-item"><a href="<?php echo $path; ?>vacunas.php" class="nav-link">Vacunas</a></li>
                    <li class="nav-item"><a href="<?php echo $path; ?>calendario.php" class="nav-link">Calendario</a></li>
                    <li class="nav-item"><a href="<?php echo $path; ?>notificaciones.php" class="nav-link">Notificaciones</a></li>
                    <li class="nav-item"><a href="<?php echo $path; ?>centros.php" class="nav-link">Centros</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>