<?php
session_start();
require_once '../database/db.php';

if (isset($_GET['ocultar_aviso'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['ocultar_aviso']);
    
    // Cambiamos el estado a 1 (leído/oculto)
    $sql = "UPDATE citas SET aviso_leido = 1 WHERE id = '$id'";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: ../vistas/notificaciones.php");
    } else {
        echo "Error al ocultar aviso: " . mysqli_error($conexion);
    }
    exit();
}