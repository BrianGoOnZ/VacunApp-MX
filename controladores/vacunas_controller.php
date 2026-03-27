<?php
include '../database/db.php';
include '../modelos/Vacuna.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo = new Vacuna($conexion);
    $accion = $_POST['accion'] ?? '';
    $vacuna = $_POST['vacuna'];
    $enfermedad = $_POST['enfermedad'];
    $dosis = $_POST['dosis'];
    $frecuencia = $_POST['frecuencia'];
    $fecha = $_POST['fecha'];
    if ($accion == 'crear') {
        if ($modelo->crear($vacuna, $enfermedad, $dosis, $frecuencia, $fecha)) {
            header("Location: ../vistas/vacunas.php?msj=vac_guardada");
        } else {
            header("Location: ../vistas/vacunas.php?msj=error");
        }
    } 
    elseif ($accion == 'actualizar') {
        $id = $_POST['id'];
        
        if ($modelo->actualizar($id, $vacuna, $enfermedad, $dosis, $frecuencia, $fecha)) {
            header("Location: ../vistas/vacunas.php?msj=vac_actualizada");
        } else {
            header("Location: ../vistas/vacunas.php?msj=error");
        }
    }
    exit(); 
} else {
    header("Location: ../vistas/vacunas.php");
    exit();
}