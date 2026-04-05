<?php
session_start(); // 1. CRÍTICO: Iniciamos sesión para poder usar $_SESSION
include '../database/db.php';
include '../modelos/Vacuna.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo = new Vacuna($conexion);
    
    // 2. Extraemos el ID del usuario de la sesión
    $id_usuario = $_SESSION['id_usuario'] ?? null;
    
    if (!$id_usuario) {
        die("Error: No hay una sesión activa. Por favor, inicia sesión de nuevo.");
    }

    $accion = $_POST['accion'] ?? '';
    $vacuna = $_POST['vacuna'];
    $enfermedad = $_POST['enfermedad'];
    $dosis = $_POST['dosis'];
    $frecuencia = $_POST['frecuencia'];
    $fecha = $_POST['fecha'];

    if ($accion == 'crear') {
        $id_usuario = (int)$_SESSION['id_usuario']; // Forzamos que sea un número entero
        // 3. PASAMOS EL ID_USUARIO COMO PRIMER PARÁMETRO
        if ($modelo->crear($id_usuario, $vacuna, $enfermedad, $dosis, $frecuencia, $fecha)) {
            header("Location: ../vistas/vacunas.php?msj=vac_guardada");
        } else {
            header("Location: ../vistas/vacunas.php?msj=error");
        }
    } 
    elseif ($accion == 'actualizar') {
        $id = $_POST['id'];
        // Si tu método actualizar también requiere validar el usuario, pásalo también.
        // Por ahora lo dejamos así si solo edita por ID de vacuna.
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