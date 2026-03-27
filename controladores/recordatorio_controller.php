<?php
require_once '../database/db.php';
require_once '../modelos/recordatorios.php';
$recordatorioModel = new Recordatorio($conexion);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha_recordatorio'];
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        if ($recordatorioModel->actualizar($id, $titulo, $descripcion, $fecha)) {
            header("Location: ../vistas/vacunas.php?msj=rec_actualizado");
        } else {
            header("Location: ../vistas/vacunas.php?msj=error_update");
        }
    } 
    else {
        if ($recordatorioModel->crear($titulo, $descripcion, $fecha)) {
            header("Location: ../vistas/vacunas.php?msj=rec_guardado");
        } else {
            header("Location: ../vistas/vacunas.php?msj=error");
        }
    }
    exit();
}
if (isset($_GET['eliminar'])) {
    if ($recordatorioModel->eliminar($_GET['eliminar'])) {
        header("Location: ../vistas/vacunas.php?msj=rec_eliminado");
    }
    exit();
}