<?php
session_start();
if(!isset($_SESSION['usuario'])){ header("Location: ../index.php"); exit(); }
include '../database/db.php'; 
include '../modelos/Vacuna.php';
include '../modelos/recordatorios.php';

$vacunaModel = new Vacuna($conexion);
$recModel = new Recordatorio($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>VacunApp MX - Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style/style-index.css">
</head>
<body style="background-color: #f8f9fa;">
    <?php include 'componentes/navbar.php'; ?>

    <main class="container mt-5">
        <?php if(isset($_GET['msj'])): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php 
                    if($_GET['msj']=='rec_guardado') echo "¡Recordatorio añadido!";
                    if($_GET['msj']=='rec_eliminado') echo "Recordatorio borrado.";
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="d-grid gap-3">
                    <button class="btn p-3 shadow-sm text-white" data-bs-toggle="modal" data-bs-target="#modalAgregarVacuna" style="background-color: #000291; border-radius: 12px; font-weight: bold;">
                        <i class="fas fa-plus-circle me-2"></i>Añadir Vacuna
                    </button>
                    <button class="btn p-3 shadow-sm text-white" data-bs-toggle="modal" data-bs-target="#modalAgregarRecordatorio" style="background-color: #007bff; border-radius: 12px; font-weight: bold;">
                        <i class="fas fa-bell me-2"></i>Nuevo Recordatorio
                    </button>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold" style="color: #000291;">Mis Vacunas</h5></div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light"><tr><th>Vacuna</th><th>Dosis</th><th>Fecha</th><th>Acciones</th></tr></thead>
                            <tbody>
                                <?php
                                $resV = $vacunaModel->listar();
                                while($v = mysqli_fetch_assoc($resV)){
                                    echo "<tr><td>{$v['nombre_vacuna']}</td><td>{$v['dosis']}</td><td>{$v['fecha']}</td>
                                    <td><a href='../controladores/eliminar_vacuna.php?id={$v['id']}' class='text-danger'><i class='fas fa-trash'></i></a></td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3"><h5 class="mb-0 fw-bold" style="color: #007bff;">Próximos Recordatorios</h5></div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light"><tr><th>Título</th><th>Fecha</th><th>Acciones</th></tr></thead>
                            <tbody>
                                <?php
                                $resR = $recModel->listar();
                                while($r = mysqli_fetch_assoc($resR)){
                                    echo "<tr>
                                        <td><strong>{$r['titulo']}</strong><br><small>{$r['descripcion']}</small></td>
                                        <td>".date("d/m/Y", strtotime($r['fecha_recordatorio']))."</td>
                                        <td><a href='../controladores/recordatorio_controller.php?eliminar={$r['id']}' class='text-danger' onclick='return confirm(\"¿Borrar?\")'><i class='fas fa-trash-alt'></i></a></td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'componentes/modales/modal_agregar.php'; ?>
    <?php include 'componentes/modales/modal_recordatorio.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>