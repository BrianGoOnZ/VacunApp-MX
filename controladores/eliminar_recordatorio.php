<?php
// controladores/eliminar_recordatorio.php
require_once '../database/db.php';
require_once '../modelos/recordatorios.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $recordatorioModel = new Recordatorio($conexion);
    
    if ($recordatorioModel->eliminar($id)) {
        // Regresamos con mensaje de éxito
        header("Location: ../vistas/vacunas.php?msj=eliminado");
    } else {
        // Regresamos con mensaje de error
        header("Location: ../vistas/vacunas.php?msj=error_eliminar");
    }
    exit();
} else {
    // Si alguien entra al archivo sin un ID, lo mandamos de regreso
    header("Location: ../vistas/vacunas.php");
    exit();
}