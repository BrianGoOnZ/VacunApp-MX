<?php
// 1. Conexión a la base de datos
$servidor = "localhost";
$usuario  = "root";
$password = "abril123"; // Tu contraseña de XAMPP
$base_datos = "test";   // Tu base de datos

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VacunApp MX - Mis Vacunas</title>
    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tus estilos (asegúrate de que las rutas sean correctas) -->
    <link rel="stylesheet" href="Styles/style-index.css">
    <link rel="stylesheet" href="Styles/disvacunas.css">
</head>
<body>
    <header class="vapp-navbar-main">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000291;">
            <div class="container-fluid">
                <a href="index.php" class="logo text-decoration-none text-white">
                    VacunApp <span class="mx" style="color: #00d4ff;">MX</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                        <li class="nav-item"><a href="vacunas.php" class="nav-link active">Vacunas</a></li>
                        <li class="nav-item"><a href="calendario.php" class="nav-link">Calendario</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Notificaciones</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Centros</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="bienvenida text-center mt-4" style="font-weight: bold; font-size: 24px;">MIS VACUNAS</div>  
        
        <div class="container mt-5">
            <div class="row">        
                <!-- SECCIÓN BOTONES -->
                <div class="col-md-3 mb-4">
                    <div class="d-grid gap-3">
                        <button class="btn btn-primary p-3 shadow" style="border-radius: 12px; font-weight: bold;" data-bs-toggle="modal" data-bs-target="#modalAgregarVacuna">
                            + Añadir vacuna
                        </button>
                        <button class="btn btn-primary p-3 shadow" style="border-radius: 12px; font-weight: bold;" data-bs-toggle="modal" data-bs-target="#modalRecordatorio">
                            + Recordatorio
                        </button>
                    </div>
                </div>

                <!-- SECCIÓN TABLA DINÁMICA -->
                <div class="col-md-9">
                    <div class="table-responsive shadow-sm">
                        <table class="table table-bordered text-center">
                            <thead style="background-color: #7297c1; color: white;">
                                <tr>
                                    <th style="background-color: #7297c1;">Vacuna</th>
                                    <th style="background-color: #7297c1;">ENFERMEDAD</th>
                                    <th style="background-color: #7297c1;">DOSIS</th>
                                    <th style="background-color: #7297c1;">FRECUENCIA</th>
                                    <th style="background-color: #7297c1;">FECHA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // CONSULTA A LA BASE DE DATOS
                                $query = "SELECT * FROM vacunas";
                                $resultado = $conexion->query($query);

                                if ($resultado->num_rows > 0) {
                                    while($fila = $resultado->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td style='background-color: #94b8d7; font-weight: bold;'>" . $fila['nombre_vacuna'] . "</td>";
                                        echo "<td>" . $fila['enfermedad'] . "</td>";
                                        echo "<td>" . $fila['dosis'] . "</td>";
                                        echo "<td>" . $fila['frecuencia'] . "</td>";
                                        echo "<td>" . $fila['fecha'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    // Si no hay datos, mostrar filas vacías para mantener el diseño
                                    for($i=0; $i<5; $i++) {
                                        echo "<tr><td style='background-color: #94b8d7; height: 45px;'></td><td></td><td></td><td></td><td></td></tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>