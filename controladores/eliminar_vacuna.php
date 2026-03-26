<?php
include '../database/db.php';
include '../modelos/Vacuna.php';

if (isset($_GET['id'])) {
    $modelo = new Vacuna($conexion);
    $id = $_GET['id'];

    if ($modelo->eliminar($id)) {
        // Regresa a la vista con un mensaje de éxito
        header("Location: ../vistas/vacunas.php?msj=eliminado");
        exit();
    } else {
        echo "Error al eliminar el registro.";
    }
} else {
    header("Location: ../vistas/vacunas.php");
    exit();
}
?>