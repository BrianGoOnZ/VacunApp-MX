<?php
session_start(); // 1. CRÍTICO: Iniciamos sesión para sacar el ID
require_once '../database/db.php';
require_once '../modelos/recordatorios.php';

$recordatorioModel = new Recordatorio($conexion);

// 2. Extraemos el ID del usuario logueado
$id_usuario = $_SESSION['id_usuario'] ?? null;

// Si por algo no hay ID, lo mandamos al login (seguridad)
if (!$id_usuario) {
    header("Location: ../vistas/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha_recordatorio'];

    // Lógica para ACTUALIZAR
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        if ($recordatorioModel->actualizar($id, $titulo, $descripcion, $fecha)) {
            header("Location: ../vistas/vacunas.php?msj=rec_actualizado");
        } else {
            header("Location: ../vistas/vacunas.php?msj=error_update");
        }
    } 
    // Lógica para CREAR
    else {
        // 3. PASAMOS EL $id_usuario como primer parámetro
        if ($recordatorioModel->crear($id_usuario, $titulo, $descripcion, $fecha)) {
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