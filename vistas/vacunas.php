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
    <header>
        <?php include '../vistas/componentes/navbar.php'; ?>
    </header>
    <main class="container mt-5">
        <?php if(isset($_GET['msj'])): ?>
            <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 10px;">
                <?php 
                    if($_GET['msj']=='rec_guardado') echo "¡Recordatorio añadido!";
                    if($_GET['msj']=='rec_eliminado') echo "Recordatorio borrado.";
                    if($_GET['msj']=='rec_actualizado') echo "¡Recordatorio actualizado con éxito!"; 
                    if($_GET['msj']=='vac_guardada') echo "¡Vacuna registrada con éxito!";
                    if($_GET['msj']=='vac_actualizada') echo "¡Datos de la vacuna actualizados!";
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
                                    echo "<tr>
                                        <td>{$v['nombre_vacuna']}</td>
                                        <td>{$v['dosis']}</td>
                                        <td>".date("d/m/Y", strtotime($v['fecha']))."</td>
                                        <td>
                                            <button class='btn btn-sm text-primary btn-editar-vacuna' 
                                                data-id='{$v['id']}' 
                                                data-vacuna='{$v['nombre_vacuna']}' 
                                                data-enfermedad='{$v['enfermedad']}' 
                                                data-dosis='{$v['dosis']}' 
                                                data-frecuencia='{$v['frecuencia']}' 
                                                data-fecha='{$v['fecha']}'
                                                data-bs-toggle='modal' data-bs-target='#modalEditarVacuna'>
                                                <i class='fas fa-edit'></i>
                                            </button>
                                            <a href='../controladores/eliminar_vacuna.php?id={$v['id']}' class='text-danger ms-2' onclick='return confirm(\"¿Borrar vacuna?\")'>
                                                <i class='fas fa-trash'></i>
                                            </a>
                                        </td>
                                    </tr>";
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
                                        <td>
                                            <button class='btn btn-sm text-primary btn-editar-rec' 
                                                data-id='{$r['id']}' 
                                                data-titulo='{$r['titulo']}' 
                                                data-desc='{$r['descripcion']}' 
                                                data-fecha='{$r['fecha_recordatorio']}'
                                                data-bs-toggle='modal' data-bs-target='#modalEditarRecordatorio'>
                                                <i class='fas fa-edit'></i>
                                            </button>
                                            <a href='../controladores/recordatorio_controller.php?eliminar={$r['id']}' class='text-danger ms-2' onclick='return confirm(\"¿Borrar?\")'>
                                                <i class='fas fa-trash-alt'></i>
                                            </a>
                                        </td>
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
    <?php include 'componentes/modales/modal_editar_recordatorio.php'; ?>
    <?php include 'componentes/modales/modal_editar_vacuna.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // JS PARA RECORDATORIOS
            const botonesEditarRec = document.querySelectorAll('.btn-editar-rec');
            botonesEditarRec.forEach(boton => {
                boton.addEventListener('click', function() {
                    document.getElementById('edit_id').value = this.getAttribute('data-id');
                    document.getElementById('edit_titulo').value = this.getAttribute('data-titulo');
                    document.getElementById('edit_descripcion').value = this.getAttribute('data-desc'); 
                    document.getElementById('edit_fecha').value = this.getAttribute('data-fecha');
                });
            });
            const botonesEditarVac = document.querySelectorAll('.btn-editar-vacuna');
            botonesEditarVac.forEach(boton => {
                boton.addEventListener('click', function() {
                    document.getElementById('edit_vac_id').value = this.getAttribute('data-id');
                    document.getElementById('edit_vac_nombre').value = this.getAttribute('data-vacuna');
                    document.getElementById('edit_vac_enfermedad').value = this.getAttribute('data-enfermedad');
                    document.getElementById('edit_vac_dosis').value = this.getAttribute('data-dosis');
                    document.getElementById('edit_vac_frecuencia').value = this.getAttribute('data-frecuencia');
                    document.getElementById('edit_vac_fecha').value = this.getAttribute('data-fecha');
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>