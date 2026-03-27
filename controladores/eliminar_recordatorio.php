<?php
require_once '../database/db.php';
require_once '../modelos/recordatorios.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $recordatorioModel = new Recordatorio($conexion);
    if ($recordatorioModel->eliminar($id)) {
        header("Location: ../vistas/vacunas.php?msj=eliminado");
    } else {
        header("Location: ../vistas/vacunas.php?msj=error_eliminar");
    }
    exit();
} else {
    header("Location: ../vistas/vacunas.php");
    exit();
}