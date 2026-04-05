<?php
session_start();
require_once '../database/db.php';
require_once '../modelos/Cita.php';

$citaModel = new Cita($conexion);

// 1. Extraemos el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'] ?? null;

if (!$id_usuario) {
    header("Location: ../vistas/login.php?error=sesion_expirada");
    exit();
}

if (isset($_POST['btn_guardar'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $nombre = $_POST['nombre_vacuna'];
    $fecha = $_POST['fecha_vacuna'];
    $es_rec = isset($_POST['es_recordatorio']) ? 1 : 0;
    
    // 2. PASAMOS el id_usuario como PRIMER parámetro
    if ($citaModel->crear($id_usuario, $nombre, $fecha, $es_rec)) {
        header("Location: ../vistas/calendario.php?msj=guardado");
    } else {
        header("Location: ../vistas/calendario.php?msj=error");
    }
    exit();
}

if (isset($_POST['btn_editar'])) {
    $id = $_POST['id_editar'];
    $nombre = $_POST['nombre_vacuna'];
    $fecha = $_POST['fecha_vacuna'];
    
    // Si tu modelo editar también necesita validar el usuario, pásalo aquí
    if ($citaModel->editar($id, $nombre, $fecha)) {
        header("Location: ../vistas/calendario.php?msj=editado");
    } else {
        header("Location: ../vistas/calendario.php?msj=error");
    }
    exit();
}

if (isset($_GET['id']) && isset($_GET['nuevo_estado'])) {
    // Es recomendable validar que la cita pertenezca al usuario antes de cambiar estado
    if ($citaModel->actualizarEstado($_GET['id'], $_GET['nuevo_estado'])) {
        header("Location: ../vistas/calendario.php?msj=estado_actualizado");
    }
    exit();
}

if (isset($_GET['eliminar'])) {
    if ($citaModel->eliminar($_GET['eliminar'])) {
        header("Location: ../vistas/calendario.php?msj=eliminado");
    }
    exit();
}
?>