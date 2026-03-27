<?php
require_once '../database/db.php';
require_once '../modelos/recordatorios.php';

$recordatorioModel = new Recordatorio($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha_recordatorio'];
    
    // Si viene un ID, es una actualización (UPDATE)
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        if ($recordatorioModel->actualizar($id, $titulo, $descripcion, $fecha)) {
            header("Location: ../vistas/vacunas.php?msj=rec_actualizado");
        } else {
            header("Location: ../vistas/vacunas.php?msj=error_update");
        }
    } 
    // Si no hay ID, es un registro nuevo (CREATE)
    else {
        if ($recordatorioModel->crear($titulo, $descripcion, $fecha)) {
            header("Location: ../vistas/vacunas.php?msj=rec_guardado");
        } else {
            header("Location: ../vistas/vacunas.php?msj=error");
        }
    }
    exit();
}

// Lógica para eliminar si viene por GET (DELETE)
if (isset($_GET['eliminar'])) {
    if ($recordatorioModel->eliminar($_GET['eliminar'])) {
        header("Location: ../vistas/vacunas.php?msj=rec_eliminado");
    }
    exit();
}