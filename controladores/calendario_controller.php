<?php
include '../database/db.php';
include '../modelos/Cita.php';

$citaModel = new Cita($conexion);

// --- GUARDAR CITA Y GENERAR NOTIFICACIÓN ---
if (isset($_POST['btn_guardar'])) {
    $nombre = $_POST['nombre_vacuna'];
    $fecha = $_POST['fecha_vacuna'];
    $es_recordatorio = isset($_POST['es_recordatorio']) ? 1 : 0;

    // 1. Guardamos la cita en la tabla 'citas'
    if ($citaModel->crear($nombre, $fecha, $es_recordatorio)) {
        
        // 2. Si el usuario marcó que quiere recordatorio, lo insertamos en la tabla 'recordatorios'
        // O puedes quitar el 'if' si quieres que SIEMPRE genere notificación
        if ($es_recordatorio) {
            $titulo_notif = "Cita: " . $nombre;
            $desc_notif = "Recuerda tu aplicación de la vacuna " . $nombre;
            
            // Limpiamos los datos para evitar errores de SQL
            $titulo_limpio = mysqli_real_escape_string($conexion, $titulo_notif);
            $desc_limpio = mysqli_real_escape_string($conexion, $desc_notif);

            $sql_notif = "INSERT INTO recordatorios (titulo, descripcion, fecha_recordatorio) 
                          VALUES ('$titulo_limpio', '$desc_limpio', '$fecha')";
            
            mysqli_query($conexion, $sql_notif);
        }
    }
    
    header("Location: ../vistas/calendario.php");
    exit();
}

// --- ELIMINAR CITA ---
if (isset($_GET['eliminar'])) {
    $citaModel->eliminar($_GET['eliminar']);
    header("Location: ../vistas/calendario.php");
    exit();
}

// --- ACTUALIZAR ESTADO (Colores) ---
if (isset($_GET['id']) && isset($_GET['nuevo_estado'])) {
    $citaModel->actualizarEstado($_GET['id'], $_GET['nuevo_estado']);
    header("Location: ../vistas/calendario.php");
    exit();
}
?>