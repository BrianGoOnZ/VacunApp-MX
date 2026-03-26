<?php
// 1. CONEXIÓN
$conn = new mysqli("localhost", "root", "abril123", "vacunapp");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VacunApp MX - Mis Vacunas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* TUS ESTILOS EXACTOS */
        .vapp-navbar-main { background-color: #000291; padding: 10px 0; }
        .logo { color: white; font-weight: bold; font-size: 24px; }
        .logo .mx { color: #4ABEEF; }
        .nav-link { color: white !important; margin: 0 10px; }
        
        .bienvenida { font-size: 28px; font-weight: bold; color: #000291; margin-top: 20px; }

        .tabla-vapp { width: 100%; border-collapse: collapse; background-color: white; }
        .tabla-vapp thead th {
            background-color: #7294c0; 
            color: #000291;
            text-align: center;
            padding: 15px 10px;
            border: 1px solid #000291;
            font-size: 0.85rem;
            font-weight: bold;
        }
        .tabla-vapp td { border: 1px solid #000291; height: 50px; background-color: white; text-align: center; }
        .col-azul-claro { background-color: #9dbcd4 !important; width: 120px; }

        .btn-iniciarsesion {
            background-color: #000291;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .btn-iniciarsesion:hover { background-color: #4ABEEF; color: #000291; transform: translateY(-2px); }

        .modal-vapp { border-radius: 15px; overflow: hidden; border: none; }
        .modal-vapp .modal-header { background-color: #000291; color: white; border-bottom: none; }
        .modal-vapp .modal-title { font-weight: bold; letter-spacing: 1px; }
        .modal-vapp .modal-body { padding: 25px; background-color: #f8f9fa; }
        .modal-vapp .form-label { color: #000291; font-weight: bold; }
        .modal-vapp .form-control { border: 2px solid #9dbcd4; border-radius: 8px; }
        .modal-vapp .form-control:focus { border-color: #000291; box-shadow: none; }
    </style>
</head>
<body class="bg-light">

<header class="vapp-navbar-main">
    <nav class="navbar navbar-expand-lg navbar-dark container">
        <a href="index.php" class="logo text-decoration-none">
            VacunApp <span class="mx">MX</span>
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="vacunas.php" class="nav-link">Vacunas</a></li>
                <li class="nav-item"><a href="calendario.php" class="nav-link">Calendario</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Escanear</a></li>
            </ul>
            <div class="navbar-nav">
                <a href="#" class="nav-link"><i class="fas fa-user-circle fa-2x"></i></a>
            </div>
        </div>
    </nav>
</header>

<main class="container mt-5">
    <div class="bienvenida text-center mb-4">MIS VACUNAS</div>

    <div class="row">
        <div class="col-md-3">
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
                    <tr>
                        <td class="col-azul-claro">Hepatitis B</td>
                        <td>Infección por Hepatitis B</td>
                        <td>Primera</td>
                        <td>Recién nacido</td>
                        <td>2026-03-25</td>
                    </tr>
                    <!-- Repetir filas según necesites -->
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- MODAL AGREGAR VACUNA -->
<div class="modal fade" id="modalAgregarVacuna" tabindex="-1">
    <div class="modal-dialog modal-vapp">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NUEVA VACUNA</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="guardar_vacuna.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Vacuna</label>
                        <input type="text" name="vacuna" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Enfermedad</label>
                        <input type="text" name="enfermedad" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Dosis</label>
                            <input type="text" name="dosis" class="form-control">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn-iniciarsesion w-100">Guardar Vacuna</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>