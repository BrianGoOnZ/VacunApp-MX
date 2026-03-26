<?php
require_once '../database/db.php';
require_once '../modelos/recordatorios.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha_recordatorio'];

    $recordatorioModel = new Recordatorio($conexion);

    if ($recordatorioModel->crear($titulo, $descripcion, $fecha)) {
        header("Location: ../vistas/vacunas.php?msj=rec_guardado");
    } else {
        header("Location: ../vistas/vacunas.php?msj=error");
    }
    exit();
}

// Lógica para eliminar si viene por GET
if (isset($_GET['eliminar'])) {
    $recordatorioModel = new Recordatorio($conexion);
    if ($recordatorioModel->eliminar($_GET['eliminar'])) {
        header("Location: ../vistas/vacunas.php?msj=rec_eliminado");
    }
    exit();
}