<?php
include '../database/db.php';
include '../modelos/Vacuna.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo = new Vacuna($conexion);
    
    // Determinamos qué acción realizar
    $accion = $_POST['accion'];

    // Capturamos los datos comunes (necesarios para crear y actualizar)
    $vacuna = $_POST['vacuna'];
    $enfermedad = $_POST['enfermedad'];
    $dosis = $_POST['dosis'];
    $frecuencia = $_POST['frecuencia'];
    $fecha = $_POST['fecha'];

    if ($accion == 'crear') {
        // Ejecutamos CREATE
        if ($modelo->crear($vacuna, $enfermedad, $dosis, $frecuencia, $fecha)) {
            header("Location: ../vistas/vacunas.php?msj=guardado");
        } else {
            echo "Error al guardar: " . mysqli_error($conexion);
        }
    } 
    elseif ($accion == 'actualizar') {
        // Capturamos el ID (solo necesario para actualizar)
        $id = $_POST['id'];
        
        // Ejecutamos UPDATE
        if ($modelo->actualizar($id, $vacuna, $enfermedad, $dosis, $frecuencia, $fecha)) {
            header("Location: ../vistas/vacunas.php?msj=actualizado");
        } else {
            echo "Error al actualizar: " . mysqli_error($conexion);
        }
    }
    
    exit(); 
} else {
    // Si intentan entrar directo a este archivo, los mandamos a la tabla
    header("Location: ../vistas/vacunas.php");
    exit();
}
?>