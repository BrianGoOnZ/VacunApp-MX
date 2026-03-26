<?php
include '../database/db.php';

// Esta ruta busca el archivo subiendo un nivel desde 'controladores'
$ruta_modelo = dirname(__DIR__) . '/modelos/recordatorios.php';

if (file_exists($ruta_modelo)) {
    include_once $ruta_modelo;
} else {
    die("Error: El controlador no encuentra el modelo en: " . $ruta_modelo);
}

$modelo = new Recordatorio($conexion);

if (isset($_GET['eliminar_id'])) {
    if ($modelo->eliminar($_GET['eliminar_id'])) {
        header("Location: ../vistas/notificaciones.php?status=ok");
    } else {
        header("Location: ../vistas/notificaciones.php?status=error");
    }
    exit();
}
?>