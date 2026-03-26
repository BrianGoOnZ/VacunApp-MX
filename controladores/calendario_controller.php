<?php
session_start();
require_once '../database/db.php';
require_once '../modelos/Cita.php';

$citaModel = new Cita($conexion);

// GUARDAR NUEVA CITA
if (isset($_POST['btn_guardar'])) {
    $nombre = $_POST['nombre_vacuna'];
    $fecha = $_POST['fecha_vacuna'];
    $es_rec = isset($_POST['es_recordatorio']) ? 1 : 0;

    if ($citaModel->crear($nombre, $fecha, $es_rec)) {
        header("Location: ../vistas/calendario.php?msj=guardado");
    } else {
        header("Location: ../vistas/calendario.php?msj=error");
    }
    exit();
}

// EDITAR CITA EXISTENTE
if (isset($_POST['btn_editar'])) {
    $id = $_POST['id_editar'];
    $nombre = $_POST['nombre_vacuna'];
    $fecha = $_POST['fecha_vacuna'];

    if ($citaModel->editar($id, $nombre, $fecha)) {
        header("Location: ../vistas/calendario.php?msj=editado");
    } else {
        header("Location: ../vistas/calendario.php?msj=error");
    }
    exit();
}

// CAMBIAR ESTADO (Completada/Perdida)
if (isset($_GET['id']) && isset($_GET['nuevo_estado'])) {
    if ($citaModel->actualizarEstado($_GET['id'], $_GET['nuevo_estado'])) {
        header("Location: ../vistas/calendario.php?msj=estado_actualizado");
    }
    exit();
}

// ELIMINAR CITA
if (isset($_GET['eliminar'])) {
    if ($citaModel->eliminar($_GET['eliminar'])) {
        header("Location: ../vistas/calendario.php?msj=eliminado");
    }
    exit();
}
?>