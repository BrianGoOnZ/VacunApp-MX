<?php
include '../database/db.php';
include '../modelos/Cita.php';

$citaModel = new Cita($conexion);

if (isset($_POST['btn_guardar'])) {
    $citaModel->crear($_POST['nombre_vacuna'], $_POST['fecha_vacuna'], isset($_POST['es_recordatorio']));
    header("Location: ../vistas/calendario.php");
}

if (isset($_GET['eliminar'])) {
    $citaModel->eliminar($_GET['eliminar']);
    header("Location: ../vistas/calendario.php");
}

if (isset($_GET['id']) && isset($_GET['nuevo_estado'])) {
    $citaModel->actualizarEstado($_GET['id'], $_GET['nuevo_estado']);
    header("Location: ../vistas/calendario.php");
}