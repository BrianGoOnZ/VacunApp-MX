<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header("Location: ../index.php");
    exit();
}
include '../database/db.php'; 
include '../modelos/Vacuna.php';

$vacunaModel = new Vacuna($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VacunApp MX - Mis Vacunas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style/style-index.css">
</head>
<body>

    <header class="vapp-navbar-main">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a href="../index.php" class="logo text-decoration-none">
                    VacunApp <span class="mx">MX</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="../index.php" class="nav-link">Inicio</a></li>
                        <li class="nav-item"><a href="vacunas.php" class="nav-link active">Vacunas</a></li>
                        <li class="nav-item"><a href="calendario.php" class="nav-link">Calendario</a></li>
                        <li class="nav-item"><a href="notificaciones.php" class="nav-link">Notificaciones</a></li>
                        <li class="nav-item"><a href="centros.php" class="nav-link">Centros</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <div class="bienvenida-seccion mb-4">Mis Vacunas Registradas</div>

        <?php if(isset($_GET['msj']) && $_GET['msj'] == 'guardado'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">Vacuna guardada correctamente.</div>
        <?php elseif(isset($_GET['msj']) && $_GET['msj'] == 'actualizado'): ?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">Datos actualizados correctamente.</div>
        <?php elseif(isset($_GET['msj']) && $_GET['msj'] == 'eliminado'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">Registro eliminado.</div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="d-grid gap-3">
                    <button class="btn-iniciarsesion" data-bs-toggle="modal" data-bs-target="#modalAgregarVacuna">
                        <i class="fas fa-plus-circle me-2"></i>Añadir Vacuna
                    </button>
                </div>
            </div>

            <div class="col-md-9">
                <div class="table-responsive shadow-sm rounded bg-white">
                    <table class="tabla-vapp mb-0">
                        <thead>
                            <tr>
                                <th class="col-azul-claro">Vacuna</th>
                                <th>ENFERMEDAD</th>
                                <th>DOSIS</th>
                                <th>FRECUENCIA</th>
                                <th>FECHA</th>
                                <th style="width: 120px;">ACCIONES</th> </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resultado = $vacunaModel->listar();

                            if ($resultado && mysqli_num_rows($resultado) > 0) {
                                while($fila = mysqli_fetch_assoc($resultado)) {
                                    $id = $fila['id'];
                                    echo "<tr>";
                                    echo "<td class='col-azul-claro'>" . htmlspecialchars($fila['nombre_vacuna']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['enfermedad']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['dosis']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['frecuencia']) . "</td>";
                                    echo "<td>" . htmlspecialchars($fila['fecha']) . "</td>";
                                    echo "<td>
                                            <div class='d-flex justify-content-center'>
                                                <a href='#' 
                                                   class='accion-btn text-primary' 
                                                   data-bs-toggle='modal' 
                                                   data-bs-target='#modalEditarVacuna'
                                                   data-bs-id='{$id}'
                                                   data-bs-nombre='" . htmlspecialchars($fila['nombre_vacuna']) . "'
                                                   data-bs-enfermedad='" . htmlspecialchars($fila['enfermedad']) . "'
                                                   data-bs-dosis='" . htmlspecialchars($fila['dosis']) . "'
                                                   data-bs-frecuencia='" . htmlspecialchars($fila['frecuencia']) . "'
                                                   data-bs-fecha='" . htmlspecialchars($fila['fecha']) . "'>
                                                   <i class='fas fa-edit'></i>
                                                </a>

                                                <a href='../controladores/eliminar_vacuna.php?id={$id}' 
                                                   class='accion-btn text-danger' 
                                                   onclick='return confirm(\"¿Seguro que quieres eliminar este registro?\")'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </a>
                                            </div>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='py-4 text-center'>No hay vacunas registradas aún.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade modal-vapp" id="modalAgregarVacuna" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">REGISTRAR NUEVA VACUNA</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../controladores/vacunas_controller.php" method="POST">
                        <input type="hidden" name="accion" value="crear">
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
                                <label class="form-label">Frecuencia</label>
                                <input type="text" name="frecuencia" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha de Aplicación</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>
                        <button type="submit" class="btn-iniciarsesion w-100">Guardar Vacuna</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-vapp" id="modalEditarVacuna" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ACTUALIZAR DATOS DE LA VACUNA</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../controladores/vacunas_controller.php" method="POST">
                        <input type="hidden" name="accion" value="actualizar">
                        <input type="hidden" name="id" id="editar-id">
                        
                        <div class="mb-3">
                            <label class="form-label">Nombre de la Vacuna</label>
                            <input type="text" name="vacuna" id="editar-nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enfermedad</label>
                            <input type="text" name="enfermedad" id="editar-enfermedad" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Dosis</label>
                                <input type="text" name="dosis" id="editar-dosis" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Frecuencia</label>
                                <input type="text" name="frecuencia" id="editar-frecuencia" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha de Aplicación</label>
                            <input type="date" name="fecha" id="editar-fecha" class="form-control" required>
                        </div>
                        <button type="submit" class="btn-iniciarsesion w-100 mt-3">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const modalEditar = document.getElementById('modalEditarVacuna');
        modalEditar.addEventListener('show.bs.modal', event => {
            // El elemento (botón a) que disparó el modal
            const boton = event.relatedTarget;
            
            // Extraemos la información de los atributos data-bs-*
            const id = boton.getAttribute('data-bs-id');
            const nombre = boton.getAttribute('data-bs-nombre');
            const enfermedad = boton.getAttribute('data-bs-enfermedad');
            const dosis = boton.getAttribute('data-bs-dosis');
            const frecuencia = boton.getAttribute('data-bs-frecuencia');
            const fecha = boton.getAttribute('data-bs-fecha');

            // Buscamos los inputs del modal y les asignamos el valor
            modalEditar.querySelector('#editar-id').value = id;
            modalEditar.querySelector('#editar-nombre').value = nombre;
            modalEditar.querySelector('#editar-enfermedad').value = enfermedad;
            modalEditar.querySelector('#editar-dosis').value = dosis;
            modalEditar.querySelector('#editar-frecuencia').value = frecuencia;
            modalEditar.querySelector('#editar-fecha').value = fecha;
        });
    </script>
</body>
</html>